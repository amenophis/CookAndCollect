<?php

declare(strict_types=1);

namespace App\Security\Domain\UseCase\AVisitorWantsToSignup;

class Input
{
    private string $userFirstname;
    private string $userLastname;
    private string $userEmail;

    public function __construct(string $userFirstname, string $userLastname, string $userEmail)
    {
        $this->userFirstname = $userFirstname;
        $this->userLastname  = $userLastname;
        $this->userEmail     = $userEmail;
    }

    public function getUserFirstname(): string
    {
        return $this->userFirstname;
    }

    public function getUserLastname(): string
    {
        return $this->userLastname;
    }

    public function getUserEmail(): string
    {
        return $this->userEmail;
    }
}
