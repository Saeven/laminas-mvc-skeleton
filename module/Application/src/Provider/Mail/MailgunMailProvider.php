<?php

declare(strict_types=1);

namespace Application\Provider\Mail;

use Application\Entity\User;
use Exception;
use Laminas\View\Model\ViewModel;
use Mailgun\Mailgun;

use ZfcTwig\View\TwigRenderer;

use function sprintf;
use function strtr;

class MailgunMailProvider implements MailProviderInterface
{
    public function __construct(
        private TwigRenderer $twigRenderer,
        private Mailgun $mailgun,
        private string $mailgunDomain,
        private string $fromName,
        private string $fromEmail
    ) {
    }

    public function send(User $user, string $subject, ViewModel $message): void
    {
        $parameters = [
            'from' => sprintf(
                '"%s" <%s>',
                $this->fromName,
                $this->fromEmail
            ),
            'to' => sprintf(
                '"%s %s" <%s>',
                $user->getFirstName(),
                $user->getLastName(),
                $user->getEmail()
            ),
            'subject' => $subject,
            'html' => strtr(
                $this->twigRenderer->render($message),
                [
                    'USER_FIRST_NAME' => $user->getFirstName(),
                    'USER_LAST_NAME' => $user->getLastName(),
                    'USER_EMAIL' => $user->getEmail(),
                ]
            ),
        ];

        try {
            $this->mailgun->messages()->send($this->mailgunDomain, $parameters);
        } catch (Exception $x) {
            // shhh....
        }
    }

    public function applyIdentityVariables(ViewModel $viewModel): ViewModel
    {
        return $viewModel->setVariables([
            'fromName' => $this->fromName,
            'fromEmail' => $this->fromEmail,
        ]);
    }
}
