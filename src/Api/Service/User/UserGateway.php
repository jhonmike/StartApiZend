<?php

namespace Api\Service\User;

use Api\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class UserGateway implements UserGatewayInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function findUsers() : array
    {
        return $this->entityManager->getRepository(User::class)->findAll();
    }

    public function getUserById(int $id) : User
    {
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['id' => $id]);
        if (!$user)
            throw new \Exception('No user found');
        return $user;
    }

    public function saveUser(User $user) : void
    {
        if (!$user->getId()) {
            $user->generateKeys();
            $this->entityManager->persist($user);
        }
        $this->entityManager->flush();
    }

    public function removeUser(User $user) : void
    {
        $this->entityManager->remove($user);
        $this->entityManager->flush();
    }
}