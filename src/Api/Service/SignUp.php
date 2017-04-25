<?php

namespace Api\Service;

use Api\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Interop\Container\ContainerInterface;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;

class SignUp implements MiddlewareInterface
{
    private $entityManager;

    public static function factory(ContainerInterface $container) : SignUp
    {
        return new self($container->get(EntityManager::class));
    }

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function process(ServerRequestInterface $request, DelegateInterface $delegate) : JsonResponse
    {
        $parameters = $request->getAttribute('parameters', []);
        if ($this->verifyEmail($parameters['email'])) {
            throw new \Exception('Email already used', 500);
        }
        $user = $this->createUser($parameters);
        return new JsonResponse($user->toArray());
    }

    private function createUser(array $data) : User
    {
        $data['role'] = 'USER';
        $user = new User();
        $user->hydrator($data);
        $user->generateKeys();

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }

    private function verifyEmail(string $email) : bool
    {
        $result = $this->entityManager->getRepository(User::class)->findBy(['email' => $email]);
        if (count($result) > 0) {
            return true;
        }
        return false;
    }
}