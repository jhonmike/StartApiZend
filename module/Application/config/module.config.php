<?php

namespace Application;

use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [
            'home' => [
                'type' => 'Zend\Router\Http\Literal',
                'options' => [
                    'route'    => '/',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index'
                    ],
                ],
            ],
            'dashboard' => [
                'type' => 'Zend\Router\Http\Literal',
                'options' => [
                    'route'    => '/admin/dashboard',
                    'defaults' => [
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller'    => 'IndexController',
                        'action'     => 'dashboard'
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'abstract_factories' => [
            'factories' => [
                'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
                Controller\IndexController::class => InvokableFactory::class,
                'Zend\Log\LoggerAbstractServiceFactory'
            ],
        ],
    ],
    'navigation' => [
        'default' => [
            [
                'label' => 'Dashboard',
                'route' => 'dashboard',
                'resource'=> 'Application\Controller\Index',
                'privilege'=> 'view'
            ],
        ],
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => [
            'layout/layout'         => __DIR__ . '/../view/layout/layout.phtml',
            'error/404'             => __DIR__ . '/../view/error/404.phtml',
            'error/index'           => __DIR__ . '/../view/error/index.phtml'
        ],
        'template_path_stack' => [
            __DIR__ . '/../view'
        ]
    ]
];
