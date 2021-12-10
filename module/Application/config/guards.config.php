<?php

return [
    'Application' => [
        'controllers' => [
            \Application\Controller\IndexController::class => ['default' => []],
            \Application\Controller\RegistrationController::class => ['default' => []],
            \Application\Controller\LoginController::class => ['default' => []],
            \Application\Controller\TokenController::class => ['default' => ['user']],
            \Application\Controller\LogoutController::class => ['default' => []],
            \Application\Controller\VerificationController::class => ['default' => ['user']],
        ],
    ],
];
