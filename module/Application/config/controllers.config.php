<?php

declare(strict_types=1);

use Application\Controller\LogoutController;
use Application\Controller\TokenController;

return [
    'factories' => [
        TokenController::class => '\\Application\\Factory\\Controller\\TokenControllerFactory',
        LogoutController::class => '\\Application\\Factory\\Controller\\LogoutControllerFactory',
    ],
];
