<?php

declare(strict_types=1);

namespace Application\Factory\Provider\Mail;

use Application\Provider\Mail\MailgunMailProvider;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Mailgun\Mailgun;
use Psr\Container\ContainerInterface;
use ZfcTwig\View\TwigRenderer;

final class MailgunMailProviderFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $config = $container->get('Config');
        $mailgunConfig = $config['mailgun'];

        return new MailgunMailProvider(
            twigRenderer: $container->get(TwigRenderer::class),
            mailgun: Mailgun::create($mailgunConfig['key']),
            mailgunDomain: $mailgunConfig['domain'] ?? 'not set',
            fromName: $config['identity']['name'] ?? 'identity not set',
            fromEmail: $config['identity']['email'] ?? 'sender email not set',
        );
    }
}
