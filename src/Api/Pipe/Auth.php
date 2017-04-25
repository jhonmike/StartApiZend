<?php

namespace Api\Pipe;

use Api\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Interop\Container\ContainerInterface;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Auth implements MiddlewareInterface
{
    private $entityManager;

    public static function factory(ContainerInterface $container) : Auth
    {
        return new self($container->get(EntityManager::class));
    }

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function process(ServerRequestInterface $request, DelegateInterface $delegate) : ResponseInterface
    {
        $config = $request->getAttribute('config');

        $role = 'GUEST';
        $user = null;
        $token = $request->getServerParams()['HTTP_AUTHORIZATION'] ?? null;
        if ($token) {
            $user = $this->getUserByToken($token);
            $role = $user->getRole() ?? $role;
        }

        if (array_key_exists('allowed_roles', $config)
            && !in_array($role, $config['allowed_roles'])) {
            throw new \Exception("Acl no authorization", 401);
        }

        return $delegate->process($request->withAttribute('user', $user));
    }

    private function getUserByToken(string $token) : User
    {
        return $this->entityManager->getRepository(User::class)
            ->findOneBy(['token' => $token]);
    }
}