<?php

namespace Api;

class ConfigProvider
{
    public function __invoke()
    {
        return [
            'dependencies' => $this->getDependencies(),
            'routes' => $this->getRoutes(),
            'inputFilter' => $this->getInputFilter(),
            'doctrine' => $this->getDoctrineConfig(),
            // 'cors' => [
            //     'origin' => '*',
            //     'methods' => ['POST', 'GET', 'OPTIONS', 'DELETE', 'PUT'],
            //     'headers.allow' => ['content-type', 'authorization'],
            //     'headers.expose' => [],
            //     'credentials' => false,
            //     'cache' => 0,
            // ],
        ];
    }

    private function getDependencies()
    {
        return [
            'invokables' => [
                Service\Ping::class => Service\Ping::class,
                Service\Home::class => Service\Home::class,
                Service\User\UserList::class   => Service\User\UserList::class,
                Service\User\UserGet::class    => Service\User\UserGet::class,
                Service\User\UserSave::class   => Service\User\UserSave::class,
                Service\User\UserDelete::class => Service\User\UserDelete::class,
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
            'home' => [
                'path' => '/',
                'middleware' => Service\Home::class,
                'allowed_methods' => ['GET'],
                'allowed_roles' => ['GUEST'],
            ],
            'api.ping' => [
                'path' => '/api/ping',
                'middleware' => Service\Ping::class,
                'allowed_methods' => ['GET', 'POST', 'PUT', 'DELETE', 'PATCH'],
                'allowed_roles' => ['GUEST'],
            ],
            'api.user.list' => [
                'path' => '/api/users',
                'middleware' => Service\User\UserList::class,
                'allowed_methods' => ['GET'],
                'allowed_roles' => ['GUEST'],
            ],
            'api.user.get' => [
                'path' => '/api/user/:id',
                'middleware' => Service\User\UserGet::class,
                'allowed_methods' => ['GET'],
                'allowed_roles' => ['GUEST'],
                'parameters' => [
                    [
                        'name' => 'id',
                        'required' => false,
                        'validators' => [
                            [
                                'name' => 'Int'
                            ],
                        ],
                    ],
                ],
            ],
            'api.user.post' => [
                'path' => '/api/user',
                'middleware' => Service\User\UserSave::class,
                'allowed_methods' => ['POST'],
                'allowed_roles' => ['GUEST'],
                'parameters' => [
                    'inputFilter' => [
                        'name' => 'user.save',
                    ]
                ],
            ],
            'api.user.put' => [
                'path' => '/api/user/:id',
                'middleware' => Service\User\UserSave::class,
                'allowed_methods' => ['PUT', 'PATCH'],
                'allowed_roles' => ['GUEST'],
                'parameters' => [
                    [
                        'name' => 'id',
                        'required' => true,
                        'validators' => [
                            [
                                'name' => 'Int'
                            ],
                        ],
                    ],
                    'inputFilter' => [
                        'name' => 'user.save',
                    ]
                ],
            ],
            'api.user.delete' => [
                'path' => '/api/user/:id',
                'middleware' => Service\User\UserDelete::class,
                'allowed_methods' => ['DELETE'],
                'allowed_roles' => ['GUEST'],
                'parameters' => [
                    [
                        'name' => 'id',
                        'required' => false,
                        'validators' => [
                            [
                                'name' => 'Int'
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    public function getInputFilter()
    {
        return [
            'user.save' => [
                [
                    'name' => 'name',
                    'required' => true,
                    'validators' => [
                        [
                            'name' => 'StringLength',
                            'options' => [
                                'encoding' => 'UTF-8',
                                'min' => 4,
                                'max' => 100,
                            ],
                        ],
                    ],
                ],
                [
                    'name' => 'email',
                    'required' => true,
                    'validators' => [
                        [
                            'name' => 'StringLength',
                            'options' => [
                                'encoding' => 'UTF-8',
                                'min' => 10,
                                'max' => 100,
                            ],
                        ],
                        [
                            'name' => \Zend\Validator\EmailAddress::class,
                            'options' => [
                                'useMxCheck' => true
                            ]
                        ]
                    ],
                ],
                [
                    'name' => 'password',
                    'required' => true,
                    'validators' => [
                        [
                            'name' => 'StringLength',
                            'options' => [
                                'encoding' => 'UTF-8',
                                'min' => 4,
                                'max' => 100,
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }
}
