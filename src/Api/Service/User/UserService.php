<?php

namespace Api\Service\User;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;

class UserService implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        $config = $request->getAttribute('config');

        if (!array_key_exists('action', $config)) {
            throw new \Exception('Service not found', 404);
        }

        $action = $config['action'];
        return $this->$action($request, $delegate);
    }

    public function list(ServerRequestInterface $request, DelegateInterface $delegate) : JsonResponse
    {
        return new JsonResponse(['welcome' => 'User List']);
    }

    public function get(ServerRequestInterface $request, DelegateInterface $delegate) : JsonResponse
    {
        return new JsonResponse(['welcome' => 'User Get']);
    }

    public function save(ServerRequestInterface $request, DelegateInterface $delegate) : JsonResponse
    {
        return new JsonResponse(['welcome' => 'User Save']);
    }

    public function remove(ServerRequestInterface $request, DelegateInterface $delegate) : JsonResponse
    {
        return new JsonResponse(['welcome' => 'User Remove']);
    }
}
