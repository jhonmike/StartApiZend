<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        return new ViewModel();
    }

    public function clientAction()
    {
        return new ViewModel();
    }

    public function adminAction()
    {
        return new ViewModel();
    }

    public function developerAction()
    {
        return new ViewModel();
    }
}
