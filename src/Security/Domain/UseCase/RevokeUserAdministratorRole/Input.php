<?php

declare(strict_types=1);

namespace App\Security\Domain\UseCase\RevokeUserAdministratorRole;

class Input
{
    private string $userEmail;

    public function __construct(string $userEmail)
    {
        $this->userEmail = $userEmail;
    }

    public function getUserEmail(): string
    {
        return $this->userEmail;
    }
}
