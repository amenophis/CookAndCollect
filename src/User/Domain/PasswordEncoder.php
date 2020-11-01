<?php

declare(strict_types=1);

namespace App\User\Domain;

use App\User\Domain\Data\Model\User;

interface PasswordEncoder
{
    public function encode(User $user, string $password): string;
}
