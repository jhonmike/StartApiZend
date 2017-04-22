<?php

namespace Api\Service;

use Interop\Container\ContainerInterface;
use Zend\Expressive\Router\RouterInterface;

class HomeFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new Home(
            $container->get(RouterInterface::class)
        );
    }
}
