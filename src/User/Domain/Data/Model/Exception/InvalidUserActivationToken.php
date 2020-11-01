<?php

declare(strict_types=1);

namespace App\User\Domain\Data\Model\Exception;

use App\User\Domain\Data\Model\User;

class InvalidUserActivationToken extends \Exception
{
    public function __construct(User $user)
    {
        parent::__construct("Invalid activation token for user {$user->getId()}");
    }
}
