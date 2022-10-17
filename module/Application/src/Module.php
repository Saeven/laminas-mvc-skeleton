<?php

declare(strict_types=1);

namespace Application;

use Application\Listener\LayoutListener;
use Application\Listener\RegistrationListener;
use Laminas\Mvc\MvcEvent;

class Module
{
    public function getConfig(): array
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function onBootstrap(MvcEvent $mvcEvent): void
    {
        $eventManager = $mvcEvent->getApplication()->getEventManager();
        $services = $mvcEvent->getApplication()->getServiceManager();

        $services->get(LayoutListener::class)->attach($eventManager);
        $services->get(RegistrationListener::class)->attach($eventManager);
    }
}
