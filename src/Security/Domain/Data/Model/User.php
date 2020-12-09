<?php

declare(strict_types=1);

namespace App\Security\Domain\Data\Model;

use App\Security\Domain\Data\Exception\InvalidUserActivationToken;
use App\Security\Domain\Data\Exception\UserAlreadyHasAdministratorRole;
use App\Security\Domain\Data\Exception\UserDoesNotHaveAdministratorRole;

class User
{
    private string $id;
    private string $firstname;
    private string $lastname;
    private string $email;
    private ?string $password = null;
    private \DateTimeImmutable $registeredOn;
    private ?string $activationToken         = null;
    private ?\DateTimeImmutable $activatedOn = null;
    private bool $admin                      = false;

    private function __construct()
    {
    }

    public static function register(string $id, string $firstname, string $lastname, string $email, \DateTimeImmutable $registeredOn, string $activationToken): self
    {
        $self                  = new self();
        $self->id              = $id;
        $self->lastname        = $lastname;
        $self->firstname       = $firstname;
        $self->email           = $email;
        $self->registeredOn    = $registeredOn;
        $self->activationToken = $activationToken;

        return $self;
    }

    /**
     * @throws InvalidUserActivationToken
     */
    public function activate(string $activationToken, \DateTimeImmutable $activatedOn, string $encodedPassword): void
    {
        if ($this->activationToken !== $activationToken) {
            throw new InvalidUserActivationToken($this);
        }

        $this->activationToken = null;
        $this->activatedOn     = $activatedOn;
        $this->password        = $encodedPassword;
    }

    /**
     * @throws UserAlreadyHasAdministratorRole
     */
    public function grantAdministratorRole(): void
    {
        if (true === $this->admin) {
            throw new UserAlreadyHasAdministratorRole($this);
        }

        $this->admin = true;
    }

    /**
     * @throws UserDoesNotHaveAdministratorRole
     */
    public function revokeAdministratorRole(): void
    {
        if (false === $this->admin) {
            throw new UserDoesNotHaveAdministratorRole($this);
        }

        $this->admin = false;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function getFullname(): string
    {
        return "{$this->firstname} {$this->lastname}";
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function getRegisteredOn(): \DateTimeImmutable
    {
        return $this->registeredOn;
    }

    public function getActivationToken(): ?string
    {
        return $this->activationToken;
    }

    public function getActivatedOn(): ?\DateTimeImmutable
    {
        return $this->activatedOn;
    }

    public function isActivated(): bool
    {
        return null !== $this->activatedOn;
    }

    public function isAdmin(): bool
    {
        return $this->admin;
    }
}
