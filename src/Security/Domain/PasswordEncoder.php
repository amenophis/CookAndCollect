<?php

declare(strict_types=1);

namespace App\Security\Domain;

use App\Security\Domain\Data\Model\User;

interface PasswordEncoder
{
    public function encode(User $user, string $password): string;
}
