<?php

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module
{
    const VERSION = '3.0.0dev';

    public function onBootstrap(MvcEvent $e)
    {
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($e->getApplication()->getEventManager());
    }

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }
}
