<?php

declare(strict_types=1);

namespace App\Security\Domain\Data\Exception;

class UserNotFound extends \Exception
{
    private function __construct(string $message)
    {
        parent::__construct($message);
    }

    public static function byId(string $id): self
    {
        return new self("Unable to find a user with id {$id}");
    }

    public static function byActivationToken(string $activationToken): self
    {
        return new self("Unable to find a user with activation_token {$activationToken}");
    }

    public static function byEmail(string $email): self
    {
        return new self("Unable to find a user with email {$email}");
    }
}
