<?php

namespace ZfBase;

/**
 * Class Module
 * @package ZfBase
 * @author Jhon Mike <developer@jhonmike.com.br>
 */
class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }
}
