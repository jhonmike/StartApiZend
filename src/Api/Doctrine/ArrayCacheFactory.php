<?php

namespace Api\Doctrine;

use Doctrine\Common\Cache\ArrayCache;
use Interop\Container\ContainerInterface;

/**
 * @author Jhon Mike <developer@jhonmike.com.br>
 */
class ArrayCacheFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new ArrayCache();
    }
}
