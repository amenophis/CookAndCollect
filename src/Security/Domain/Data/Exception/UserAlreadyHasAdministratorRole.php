<?php

declare(strict_types=1);

namespace App\Security\Domain\Data\Exception;

use App\Security\Domain\Data\Model\User;

class UserAlreadyHasAdministratorRole extends \Exception
{
    public function __construct(User $user)
    {
        parent::__construct("User {$user->getEmail()} is already admin");
    }
}
