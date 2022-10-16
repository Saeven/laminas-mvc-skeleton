<?php

declare(strict_types=1);

use Application\Controller\ForgotPasswordController;
use Application\Controller\IndexController;
use Application\Controller\LoginController;
use Application\Controller\LogoutController;
use Application\Controller\RegistrationController;
use Application\Controller\TokenController;
use Application\Controller\VerificationController;

return [
    'Application' => [
        'controllers' => [
            IndexController::class => ['default' => []],
            RegistrationController::class => ['default' => []],
            LoginController::class => ['default' => []],
            TokenController::class => ['default' => ['user']],
            LogoutController::class => ['default' => []],
            VerificationController::class => ['default' => ['user']],
            ForgotPasswordController::class => ['default' => []],
        ],
    ],
];
