<?php

declare(strict_types=1);

namespace App\Shared\Domain\Email;

class Address
{
    private string $address;
    private string $name;

    public function __construct(string $address, string $name)
    {
        $this->address = $address;
        $this->name    = $name;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
