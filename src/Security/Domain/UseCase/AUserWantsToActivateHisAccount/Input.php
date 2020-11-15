<?php

declare(strict_types=1);

namespace App\Security\Domain\UseCase\AUserWantsToActivateHisAccount;

class Input
{
    private string $userId;
    private string $activationToken;
    private string $plainPassword;

    public function __construct(string $userId, string $activationToken, string $password)
    {
        $this->userId          = $userId;
        $this->activationToken = $activationToken;
        $this->plainPassword   = $password;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function getActivationToken(): string
    {
        return $this->activationToken;
    }

    public function getPlainPassword(): string
    {
        return $this->plainPassword;
    }
}
