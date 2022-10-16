<?php

declare(strict_types=1);

use Application\Controller\ForgotPasswordController;
use Application\Controller\IndexController;
use Application\Controller\LoginController;
use Application\Controller\LogoutController;
use Application\Controller\RegistrationController;
use Application\Controller\TokenController;
use Application\Controller\VerificationController;
use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;

return [
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
    'forgot' => [
        'type' => Literal::class,
        'options' => [
            'route' => '/forgot',
            'defaults' => [
                'controller' => ForgotPasswordController::class,
                'action' => 'index',
            ],
        ],
    ],
    'forgot-submit' => [
        'type' => Literal::class,
        'options' => [
            'route' => '/forgot-submit',
            'defaults' => [
                'controller' => ForgotPasswordController::class,
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
    'verification-resend' => [
        'type' => Literal::class,
        'options' => [
            'route' => '/verification/resend',
            'defaults' => [
                'controller' => VerificationController::class,
                'action' => 'resend',
            ],
        ],
    ],
    'verification-check' => [
        'type' => Segment::class,
        'options' => [
            'route' => '/register/verify/:verificationCode',
            'defaults' => [
                'controller' => RegistrationController::class,
                'action' => 'verify',
            ],
            'constraints' => [
                'verificationCode' => '[a-z0-9]{20}',
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
                'controller' => IndexController::class,
                'action' => 'index',
            ],
        ],
    ],
    'application' => [
        'type' => Segment::class,
        'options' => [
            'route' => '/application[/:action]',
            'defaults' => [
                'controller' => IndexController::class,
                'action' => 'index',
            ],
        ],
    ],
];
