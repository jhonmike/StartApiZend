<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * Class IndexController
 * @package Application\Controller
 * @author Jhon Mike <developer@jhonmike.com.br>
 */
class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        return new ViewModel();
    }
}
