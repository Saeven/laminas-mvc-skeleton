<?php

declare(strict_types=1);

namespace Application\Provider\Mail;

use Application\Entity\User;

interface MailProviderInterface
{
    public function send(User $user, string $subject, string $message): void;
}
