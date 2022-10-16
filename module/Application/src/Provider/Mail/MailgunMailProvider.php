<?php

declare(strict_types=1);

namespace Application\Provider\Mail;

use Application\Entity\User;
use Exception;
use Mailgun\Mailgun;

use function sprintf;
use function strtr;

class MailgunMailProvider implements MailProviderInterface
{
    public function __construct(
        private Mailgun $mailgun,
        private string $mailgunDomain,
        private string $fromName,
        private string $fromEmail
    ) {
    }

    public function send(User $user, string $subject, string $message): void
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
                $message,
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
}
