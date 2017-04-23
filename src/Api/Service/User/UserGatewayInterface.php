<?php

namespace Api\Service\User;

use Api\Entity\User;

interface UserGatewayInterface
{
    public function findUsers() : array;
    public function getUserById(int $id) : User;
    public function saveUser(User $user) : void;
    public function removeUser(User $user) : void;
}