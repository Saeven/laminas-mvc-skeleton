<?php

declare(strict_types=1);

namespace Application;

use Laminas\Mvc\MvcEvent;
use Application\Listener\LayoutListener;

class Module
{
    public function getConfig(): array
    {
        /** @var array $config */
        $config = include __DIR__ . '/../config/module.config.php';

        return $config;
    }

    public function onBootstrap(MvcEvent $e): void
    {
        $eventManager = $e->getApplication()->getEventManager();
        $application = $e->getApplication();
        $services = $application->getServiceManager();

        $services->get(LayoutListener::class)->attach($eventManager);
    }
}
