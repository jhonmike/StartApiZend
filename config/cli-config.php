<?php

use Doctrine\ORM\Tools\Console\ConsoleRunner;

require 'vendor/autoload.php';

$container = require 'config/container.php';

//$environmentName = null;

//foreach ($_SERVER['argv'] as $index => $arg) {
//    $e = explode('=', $arg);
//    $key = str_replace('-', '', $e[0]);
//
//    if ('em' == $key) {
//        $environmentName = $e[1];
//        unset($_SERVER['argv'][$index]);
//    }
//}
$em = $container->get(\Doctrine\ORM\EntityManager::class);

return ConsoleRunner::createHelperSet($em);
