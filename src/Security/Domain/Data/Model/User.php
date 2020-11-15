<?php

declare(strict_types=1);

namespace App\Security\Domain\Data\Model;

use App\Security\Domain\Data\Model\Exception\InvalidUserActivationToken;

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
}
