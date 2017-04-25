<?php

namespace Api\Service;

use Api\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Interop\Container\ContainerInterface;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Crypt\Password\Bcrypt;
use Zend\Diactoros\Response\JsonResponse;

class SignIn implements MiddlewareInterface
{
    private $entityManager;

    public static function factory(ContainerInterface $container) : SignIn
    {
        return new SignIn($container->get(EntityManager::class));
    }

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function process(ServerRequestInterface $request, DelegateInterface $delegate) : JsonResponse
    {
        $parameters = $request->getAttribute('parameters', []);
        $email = $parameters['email'];
        $password = $parameters['password'];
        try {
            $entity = $this->getUserByEmailAndPassword($email, $password);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

        return new JsonResponse($entity->toArray());
    }

    private function getUserByEmailAndPassword(string $email, string $password) : User
    {
        $user = $this->entityManager
            ->getRepository(User::class)
            ->findOneBy(['email' => $email]);

        if (empty($user)) {
            throw new \Exception("Email invalid", 500);
        }

        $bcrypt = new Bcrypt();
        if (!$bcrypt->verify($password, $user->getPassword())) {
            throw new \Exception("Password invalid", 500);
        }

        $user->setLastLogin(new \DateTime());
        $user->generateToken();
        $this->entityManager->flush();

        return $user;
    }
}