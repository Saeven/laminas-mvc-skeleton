<?php

declare(strict_types=1);

namespace Application;

use Application\Controller\LoginController;
use Application\Controller\LogoutController;
use Application\Controller\RegistrationController;
use Application\Controller\TokenController;
use Application\Entity\User;
use Application\Factory\Listener\LayoutListenerFactory;
use Application\Listener\LayoutListener;
use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\Factory\InvokableFactory;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;

return [

    'circlical' => [
        'user' => [
            'guards' => require __DIR__ . DIRECTORY_SEPARATOR . 'guards.config.php',
            'doctrine' => [
                'entity' => User::class,
            ],
        ],
    ],

    'doctrine' => [
        'driver' => [
            __NAMESPACE__ . '_driver' => [
                'class' => AnnotationDriver::class,
                'cache' => 'array',
                'paths' => [
                    __DIR__ . '/../src/Entity',
                ],
            ],
            'orm_default' => [
                'drivers' => [
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver',
                ],
            ],
        ],
        'fixture' => [
            __NAMESPACE__ => __DIR__ . '/../src/' . __NAMESPACE__ . '/Fixture',
        ],
    ],

    'zfctwig' => [
        'disable_zf_model' => false,
        'extensions' => [
            new \Twig\Extra\String\StringExtension(),
            new \Twig\Extra\Intl\IntlExtension(),
        ],
    ],

    'assetic_configuration' => require __DIR__ . DIRECTORY_SEPARATOR . 'assetic.config.php',

    'router' => [
        'routes' => [
            'register' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/register',
                    'defaults' => [
                        'controller' => RegistrationController::class,
                        'action' => 'index',
                    ],
                ],
            ],

            'register-submit' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/register-submit',
                    'defaults' => [
                        'controller' => RegistrationController::class,
                        'action' => 'submit',
                    ],
                ],
            ],

            'login' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/login',
                    'defaults' => [
                        'controller' => LoginController::class,
                        'action' => 'index',
                    ],
                ],
            ],

            'login-submit' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/login-submit',
                    'defaults' => [
                        'controller' => LoginController::class,
                        'action' => 'submit',
                    ],
                ],
            ],

            'token-add' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/token/add',
                    'defaults' => [
                        'controller' => TokenController::class,
                        'action' => 'add',
                    ],
                ],
            ],

            'token-delete' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/token/delete',
                    'defaults' => [
                        'controller' => TokenController::class,
                        'action' => 'delete',
                    ],
                ],
            ],

            'logout' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/logout',
                    'defaults' => [
                        'controller' => LogoutController::class,
                        'action' => 'logout',
                    ],
                ],
            ],

            //
            // Boilerplate Routes Below
            //
            'home' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action' => 'index',
                    ],
                ],
            ],
            'application' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/application[/:action]',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action' => 'index',
                    ],
                ],
            ],
        ],
    ],

    'controllers' => require __DIR__ . DIRECTORY_SEPARATOR . 'controllers.config.php',

    'form_elements' => require __DIR__ . DIRECTORY_SEPARATOR . 'forms.config.php',

    'input_filters' => require __DIR__ . DIRECTORY_SEPARATOR . 'inputfilters.config.php',

    'controller_plugins' => [
        'factories' => [
            \Application\Controller\Plugin\JsonWrapper::class => \Application\Factory\Controller\Plugin\JsonWrapperFactory::class,
        ],
        'aliases' => [
            'json' => \Application\Controller\Plugin\JsonWrapper::class,
        ],
    ],

    'view_helpers' => [
        'factories' => [
            'AssetHelper' => \Application\Factory\View\Helper\AssetHelperFactory::class,
        ],
    ],

    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'exception_template' => 'error/index',
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
        'strategies' => [
            'ViewJsonStrategy',
        ],
    ],

    'service_manager' => [
        'factories' => [
            LayoutListener::class => LayoutListenerFactory::class,
        ],
    ],
];
