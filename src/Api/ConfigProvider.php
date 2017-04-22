<?php

namespace Api;

class ConfigProvider
{
    public function __invoke()
    {
        return [
            'dependencies' => $this->getDependencies(),
            'routes' => $this->getRoutes(),
            'doctrine' => $this->getDoctrineConfig()
        ];
    }

    private function getDependencies()
    {
        return [
            'invokables' => [
                Service\Ping::class => Service\Ping::class,
            ],
            'factories'  => [
                Service\Home::class => Service\HomeFactory::class,
                \Doctrine\Common\Cache\Cache::class => \Core\Doctrine\ArrayCacheFactory::class,
                \Doctrine\ORM\EntityManager::class => \Core\Doctrine\EntityManagerFactory::class,
                \Doctrine\DBAL\Migrations\Migration::class => \Core\Doctrine\MigrationFactory::class,
            ],
        ];
    }

    private function getDoctrineConfig()
    {
        return [
            'connection' => [
                'driver'   => 'pdo_mysql',
                'host'     => '127.0.0.1',
                'port'     => '3306',
                'user'     => 'root',
                'password' => 'root',
                'dbname'   => 'db_api',
                'charset'  => 'UTF8',
                'unix_socket' => '/tmp/mysql.sock'
            ],
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
            'home' => [
                'path' => '/',
                'middleware' => Service\Home::class,
                'allowed_methods' => ['GET']
            ],
            'api.ping' => [
                'path' => '/api/ping',
                'middleware' => Service\Ping::class,
                'allowed_methods' => ['GET', 'POST', 'PUT', 'DELETE', 'PATCH'],
            ],
        ];
    }
}
