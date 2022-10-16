<?php

declare(strict_types=1);

namespace Application;

use Application\Controller\Plugin\JsonWrapper;
use Application\Entity\User;
use Application\Factory\Controller\Plugin\JsonWrapperFactory;
use Application\Factory\Listener\LayoutListenerFactory;
use Application\Factory\Listener\RegistrationListenerFactory;
use Application\Factory\Provider\Mail\MailgunMailProviderFactory;
use Application\Factory\Service\UserServiceFactory;
use Application\Factory\View\Helper\AssetHelperFactory;
use Application\Listener\LayoutListener;
use Application\Listener\RegistrationListener;
use Application\Provider\Mail\MailProviderInterface;
use Application\Service\UserService;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Twig\Extra\Intl\IntlExtension;
use Twig\Extra\String\StringExtension;

use const DIRECTORY_SEPARATOR;

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
            new StringExtension(),
            new IntlExtension(),
        ],
    ],
    'assetic_configuration' => require __DIR__ . DIRECTORY_SEPARATOR . 'assetic.config.php',
    'router' => [
        'routes' => require __DIR__ . DIRECTORY_SEPARATOR . 'routes.config.php',
    ],
    'controllers' => require __DIR__ . DIRECTORY_SEPARATOR . 'controllers.config.php',
    'form_elements' => require __DIR__ . DIRECTORY_SEPARATOR . 'forms.config.php',
    'input_filters' => require __DIR__ . DIRECTORY_SEPARATOR . 'inputfilters.config.php',
    'controller_plugins' => [
        'factories' => [
            JsonWrapper::class => JsonWrapperFactory::class,
        ],
        'aliases' => [
            'json' => JsonWrapper::class,
        ],
    ],
    'view_helpers' => [
        'factories' => [
            'AssetHelper' => AssetHelperFactory::class,
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
            RegistrationListener::class => RegistrationListenerFactory::class,
            UserService::class => UserServiceFactory::class,
            MailProviderInterface::class =>  MailgunMailProviderFactory::class,
        ],
    ],
];
