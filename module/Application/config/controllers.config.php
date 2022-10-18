<?php

declare(strict_types=1);

use Application\Controller\DashboardController;
use Application\Controller\LogoutController;
use Application\Controller\ReportController;
use Application\Controller\ResetPasswordController;
use Application\Controller\TokenController;

return [
    'factories' => [
        TokenController::class => '\\Application\\Factory\\Controller\\TokenControllerFactory',
        LogoutController::class => '\\Application\\Factory\\Controller\\LogoutControllerFactory',
        ResetPasswordController::class => '\\Application\\Factory\\Controller\\ResetPasswordControllerFactory',
        ReportController::class => '\\Application\\Factory\\Controller\\ReportControllerFactory',
        DashboardController::class => '\\Application\\Factory\\Controller\\DashboardControllerFactory',
    ],
];
