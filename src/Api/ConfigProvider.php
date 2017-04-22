<?php

namespace Api;

class ConfigProvider
{
    public function __invoke()
    {
        return [
            'dependencies' => $this->getDependencies(),
            'routes' => $this->getRoutes(),
            'doctrine' => $this->getDoctrineConfig(),
            // 'cors' => [
            //     'origin' => '*',
            //     'methods' => ['POST', 'GET', 'OPTIONS', 'DELETE', 'PUT'],
            //     'headers.allow' => ['content-type', 'authorization'],
            //     'headers.expose' => [],
            //     'credentials' => false,
            //     'cache' => 0,
            // ]
        ];
    }

    private function getDependencies()
    {
        return [
            'invokables' => [
                Service\Ping::class => Service\Ping::class,
                Service\Home::class => Service\Home::class,
            ],
            'factories'  => [
                Pipe\Cors::class => [Pipe\Cors::class, 'factory'],
                Pipe\InputFilterValid::class => [Pipe\InputFilterValid::class, 'factory'],

                \Doctrine\Common\Cache\Cache::class => Doctrine\ArrayCacheFactory::class,
                \Doctrine\ORM\EntityManager::class => Doctrine\EntityManagerFactory::class,
                \Doctrine\DBAL\Migrations\Migration::class => Doctrine\MigrationFactory::class,
            ],
        ];
    }

    private function getDoctrineConfig()
    {
        return [
            // 'connection' => [
            //     'driver'   => 'pdo_mysql',
            //     'host'     => '127.0.0.1',
            //     'port'     => '3306',
            //     'user'     => 'root',
            //     'password' => 'root',
            //     'dbname'   => 'db_api',
            //     'charset'  => 'UTF8',
            //     'unix_socket' => '/tmp/mysql.sock'
            // ],
            'annotation' => [
                'metadata' => [
                    'src/Api/Entity',
                ],
            ],
            'migrations_configuration' => [
                'directory' => 'src/Api/Migrations',
                'name'      => 'DBAL Migrations',
                'namespace' => 'Migrations',
                'table'     => 'migration_versions',
            ],
            'orm' => [
                'auto_generate_proxy_classes' => false,
                'proxy_dir'                   => 'data/cache/EntityProxy',
                'proxy_namespace'             => 'EntityProxy',
                'underscore_naming_strategy'  => true,
            ],
        ];
    }

    private function getRoutes()
    {
        return [
            '/' => [
                'name' => 'home',
                'middleware' => Service\Home::class,
                'allowed_methods' => ['GET']
            ],
            '/api/ping' => [
                'name' => 'api.ping',
                'middleware' => Service\Ping::class,
                'allowed_methods' => ['GET', 'POST', 'PUT', 'DELETE', 'PATCH'],
            ],
        ];
    }
}
