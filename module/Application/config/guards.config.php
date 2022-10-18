<?php

declare(strict_types=1);

use Application\Controller\DashboardController;
use Application\Controller\ForgotPasswordController;
use Application\Controller\IndexController;
use Application\Controller\LoginController;
use Application\Controller\LogoutController;
use Application\Controller\RegistrationController;
use Application\Controller\ReportController;
use Application\Controller\ResetPasswordController;
use Application\Controller\TokenController;
use Application\Controller\VerificationController;

return [
    'Application' => [
        'controllers' => [
            IndexController::class => ['default' => ['user']],
            RegistrationController::class => ['default' => []],
            LoginController::class => ['default' => []],
            TokenController::class => ['default' => ['user']],
            LogoutController::class => ['default' => []],
            VerificationController::class => ['default' => ['user']],
            ForgotPasswordController::class => ['default' => []],
            ResetPasswordController::class => ['default' => []],
            ReportController::class => ['default' => ['user']],
            DashboardController::class => ['default' => ['user']],
        ],
    ],
];
