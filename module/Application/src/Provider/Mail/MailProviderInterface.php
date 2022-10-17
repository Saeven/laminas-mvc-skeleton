<?php

declare(strict_types=1);

namespace Application\Provider\Mail;

use Application\Entity\User;
use Laminas\View\Model\ViewModel;

interface MailProviderInterface
{
    public function send(User $user, string $subject, ViewModel $message): void;

    public function applyIdentityVariables(ViewModel $viewModel): ViewModel;
}
