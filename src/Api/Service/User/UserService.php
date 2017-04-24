<?php

namespace Api\Service\User;

use Api\Entity\User;
use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;

class UserService implements MiddlewareInterface
{
    private $gateway;

    public static function factory(ContainerInterface $container) : UserService
    {
        return new self(
            new UserGateway($container->get(EntityManager::class))
        );
    }

    public function __construct(UserGatewayInterface $gateway)
    {
        $this->gateway = $gateway;
    }

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
        $users = $this->gateway->findUsers();
        foreach ($users as $key => $user) {
            $users[$key] = $user->toArray();
        }
        return new JsonResponse($users);
    }

    public function get(ServerRequestInterface $request, DelegateInterface $delegate) : JsonResponse
    {
        try {
            $user = $this->gateway->getUserById($request->getAttribute('id'));
        } catch (\Exception $e) {
            return new JsonResponse(['message' => $e->getMessage()]);
        }
        return new JsonResponse($user->toArray());
    }

    public function save(ServerRequestInterface $request, DelegateInterface $delegate) : JsonResponse
    {
        $parameters = $request->getAttribute('parameters', []);
        $parameters['role'] = $parameters['role'] ?? 'USER';
        $user = new User();
        if ($request->getAttribute('id', false)) {
            $user = $this->gateway->getUserById($request->getAttribute('id'));
        }
        $user->hydrator($parameters);
        $this->gateway->saveUser($user);

        return new JsonResponse($user->toArray());
    }

    public function remove(ServerRequestInterface $request, DelegateInterface $delegate) : JsonResponse
    {
        try {
            $user = $this->gateway->getUserById($request->getAttribute('id'));
        } catch (\Exception $e) {
            return new JsonResponse(['message' => $e->getMessage()]);
        }
        $this->gateway->removeUser($user);
        return new JsonResponse(['message' => 'success']);
    }
}
