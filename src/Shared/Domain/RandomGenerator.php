<?php

declare(strict_types=1);

namespace App\Shared\Domain;

interface RandomGenerator
{
    public function generate(int $length): string;
}
