<?php

declare(strict_types=1);

namespace App\Security\Domain;

interface PasswordEncoder
{
    public function encode(string $password): string;
}
