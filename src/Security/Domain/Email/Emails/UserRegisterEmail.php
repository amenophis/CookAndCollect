<?php

declare(strict_types=1);

namespace App\Security\Domain\Email\Emails;

use App\Security\Domain\Data\Model\User;
use App\Shared\Domain\Email\Address;
use App\Shared\Domain\Email\Email;

class UserRegisterEmail extends Email
{
    public function __construct(User $user)
    {
        parent::__construct(
            [new Address($user->getEmail(), $user->getFullname())],
            'Confirm your email',
            'emails/user/confirm_email.html.twig',
            [
                'user' => $user,
            ]
        );
    }
}
