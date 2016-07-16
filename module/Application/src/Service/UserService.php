<?php

namespace Application\Service;

use Application\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Zend\Hydrator;

/**
 * Class UserService
 * @package Application\Service
 * @author Jhon Mike <developer@jhonmike.com.br>
 */
class UserService
{
    private $em;
    private $entity;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->entity = User::class;
    }

    public function persist(array $data, Integer $id = null) : User
    {
        if (empty($data['password']))
            unset($data['password']);

        if ($id) {
            $entity = $this->em->getReference($this->entity, $id);
            $hydrator = new Hydrator\ClassMethods();
            $hydrator->hydrate($data, $entity);
        } else {
            $entity = new $this->entity($data);
        }

        $this->em->persist($entity);
        $this->em->flush();

        return $entity;
    }

    public function delete(Integer $id) : Integer
    {
        $entity = $this->em->getReference($this->entity, $id);

        if ($entity) {
            $this->em->remove($entity);
            $this->em->flush();
        }

        return $id;
    }
}
