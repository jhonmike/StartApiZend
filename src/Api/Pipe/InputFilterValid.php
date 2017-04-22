<?php

namespace Api\Pipe;

use Interop\Container\ContainerInterface;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Locale;
use Zend\Diactoros\Response\JsonResponse;
use Zend\InputFilter\Factory;

class InputFilterValid implements MiddlewareInterface
{
    private $config;

    public static function factory(ContainerInterface $container)
    {
        return new self(
            $container->get('config')
        );
    }

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        $path = $request->getServerParams()['REQUEST_URI'];
        $method = $request->getServerParams()['REQUEST_METHOD'] ?? 'NOT_METHOD';
        $lang = $request->getServerParams()['HTTP_ACCEPT_LANGUAGE'] ?? 'pt-BR';
        Locale::setDefault($this->parseLang($lang));

        $config = $this->config['routes'][$path] ?? [];
        if (!isset($config['parameters']))
            return $delegate->process($request->withAttribute('config', $config));

        $parameters = $config['parameters'];
        $factory = new Factory();
        $inputFilter = $factory->createInputFilter($parameters);
        if (in_array($method, ['GET', 'DELETE'], true))
            $inputFilter->setData($request->getQueryParams());
        if (in_array($method, ['POST', 'PUT'], true))
            $inputFilter->setData($request->getParsedBody());

        if ($inputFilter->isValid()) {
            if (in_array($method, ['GET', 'DELETE'], true))
                $request = $request->withQueryParams($inputFilter->getValues());
            if (in_array($method, ['POST', 'PUT'], true))
                $request = $request->withParsedBody($inputFilter->getValues());
            return $delegate->process($request->withAttribute('config', $config));
        }

        $errors = [];
        foreach ($inputFilter->getInvalidInput() as $key => $error) {
            $errors[$key] = $error->getMessages();
        }
        return new JsonResponse($errors, 500);
    }

    private function parseLang($httpLang) : string
    {
        $langs = explode(',', $httpLang);
        $lang = str_replace('-', '_', $langs[0]);
        return $lang;
    }
}
