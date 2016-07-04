<?php

namespace ZfBase\src;

use Zend\Mvc\Controller\AbstractRestfulController as ZendAbstractRestfulController;
use Zend\View\Model\JsonModel;

/**
 * Class AbstractRestController
 * @package ZfBase\src
 * @author Jhon Mike <developer@jhonmike.com.br>
 */
abstract class AbstractRestfulController extends ZendAbstractRestfulController
{
    private $em;
    private $entity;
    private $service;

    public function indexAction()
    {
        return new JsonModel();
    }

    public function createAction()
    {
        return new JsonModel();
    }

    public function readAction()
    {
        $id = $this->params()->fromRoute('id');

        return new JsonModel();
    }

    public function updateAction()
    {
        $id = $this->params()->fromRoute('id');

        return new JsonModel();
    }

    public function deleteAction()
    {
        $id = $this->params()->fromRoute('id');

        return new JsonModel();
    }
}
