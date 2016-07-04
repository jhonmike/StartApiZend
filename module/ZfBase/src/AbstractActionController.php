<?php

namespace ZfBase\src;

use Zend\Mvc\Controller\AbstractActionController as ZendAbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * Class AbstractController
 * @package ZfBase\src
 * @author Jhon Mike <developer@jhonmike.com.br>
 */
abstract class AbstractActionController extends ZendAbstractActionController
{
    private $em;
    private $service;
    private $entity;
    private $form;
    private $route;
    private $controller;

    public function indexAction()
    {
        return new ViewModel();
    }

    public function createAction()
    {
        return new ViewModel();
    }

    public function readAction()
    {
        $id = $this->params()->fromRoute('id');

        return new ViewModel();
    }

    public function updateAction()
    {
        $id = $this->params()->fromRoute('id');

        return new ViewModel();
    }

    public function deleteAction()
    {
        $id = $this->params()->fromRoute('id');

        return new ViewModel();
    }
}
