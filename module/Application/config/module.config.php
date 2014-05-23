<?php

return array(
    'version' => '© 2014 By Jhon Mike. https://github.com/jhonmike',
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
                // 'may_terminate' => true,
                // 'child_routes' => array(
                //     'default' => array(
                //         'type' => 'Segment',
                //         'options' => array(
                //             'route' => '[/:action]',
                //             'constraints' => array(
                //                 'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                //                 'action' => '[a-zA-Z][a-zA-Z0-9_-]*'
                //             ),
                //             'defaults' => array(
                //                 '__NAMESPACE__' => 'Application\Controller',
                //                 'controller' => 'Index'
                //             )
                //         )
                //     )
                // )
            ),
            'home-client' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/client',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action'     => 'client',
                    ),
                ),
            ),
            'home-admin' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/admin',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action'     => 'admin',
                    ),
                ),
            ),
            'home-dev' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/dev',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action'     => 'developer',
                    ),
                ),
            ),
        ),
    ),
    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
        'aliases' => array(
            'translator' => 'MvcTranslator',
        ),
    ),
    'translator' => array(
        'locale' => 'pt_BR',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Application\Controller\Index' => 'Application\Controller\IndexController',
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'         => __DIR__ . '/../view/layout/layout.phtml',
            'layout/admin'          => __DIR__ . '/../view/layout/admin.phtml',
            'layout/developer'      => __DIR__ . '/../view/layout/developer.phtml',
            'error/404'             => __DIR__ . '/../view/error/404.phtml',
            'error/index'           => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    // Placeholder for console routes
    'console' => array(
        'router' => array(
            'routes' => array(
            ),
        ),
    ),
);
