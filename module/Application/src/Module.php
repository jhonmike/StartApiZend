<?php

namespace Application;

use Zend\ModuleManager\Feature\ConfigProviderInterface;

/**
 * Class Module
 * @package Application
 * @author Jhon Mike <developer@jhonmike.com.br>
 */
class Module implements ConfigProviderInterface
{
    const VERSION = '3.0.0dev';

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }
}
