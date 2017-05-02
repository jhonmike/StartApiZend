<?php

namespace Api\Pipe;

use Interop\Container\ContainerInterface;
use Tuupola\Middleware\Cors;

class CorsFactory
{
    public function __invoke(ContainerInterface $container) : Cors {
        return new Cors($container->get('config')['cors']);
    }
}