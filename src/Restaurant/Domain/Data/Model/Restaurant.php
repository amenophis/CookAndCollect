<?php

declare(strict_types=1);

namespace App\Restaurant\Domain\Data\Model;

class Restaurant
{
    private string $id;
    private string $name;
    private string $ownerId;
    private \DateTimeImmutable $registeredAt;

    private function __construct()
    {
    }

    public static function register(string $id, string $name, string $ownerId, \DateTimeImmutable $registeredAt): self
    {
        $self               = new self();
        $self->id           = $id;
        $self->name         = $name;
        $self->ownerId      = $ownerId;
        $self->registeredAt = $registeredAt;

        return $self;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getOwnerId(): string
    {
        return $this->ownerId;
    }

    public function getRegisteredAt(): \DateTimeImmutable
    {
        return $this->registeredAt;
    }
}
