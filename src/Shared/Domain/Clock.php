<?php

declare(strict_types=1);

namespace App\Shared\Domain;

interface Clock
{
    public function now(): \DateTimeImmutable;
}
