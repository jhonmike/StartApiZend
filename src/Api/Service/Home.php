<?php

namespace Api\Service;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface as ServerMiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Expressive\Router;

class Home implements ServerMiddlewareInterface
{
    private $router;

    public function __construct(Router\RouterInterface $router)
    {
        $this->router   = $router;
    }

    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        return new JsonResponse([
            'welcome' => 'Congratulations! You have installed the zend-expressive skeleton application.',
            'docsUrl' => 'https://docs.zendframework.com/zend-expressive/',
        ]);
    }
}
