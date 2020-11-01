<?php

declare(strict_types=1);

namespace App\User\Domain\Email\Emails;

use App\User\Domain\Data\Model\User;
use App\User\Domain\Email\Address;
use App\User\Domain\Email\Email;

class UserRegisterEmail extends Email
{
    public function __construct(User $user)
    {
        parent::__construct(
            [new Address($user->getEmail(), $user->getFullname())],
            'Cook and Collect - Confirm your email',
            'emails/user/confirm_email.html.twig',
            [
                'user' => $user,
            ]
        );
    }
}
