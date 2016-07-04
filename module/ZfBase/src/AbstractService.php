<?php

namespace ZfBase\src;

/**
 * Class AbstractService
 * @package ZfBase\src
 * @author Jhon Mike <developer@jhonmike.com.br>
 */
abstract class AbstractService
{
    private $em;
    private $entity;
    public function __construct($em)
    {
        $this->em = $em;
    }
    public function persist(array $data, $id = null)
    {
        return null;
    }
    public function delete($id)
    {
        return null;
    }
}
