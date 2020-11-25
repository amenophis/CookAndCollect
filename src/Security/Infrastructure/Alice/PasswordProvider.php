<?php

declare(strict_types=1);

namespace App\Security\Infrastructure\Alice;

use App\Security\Infrastructure\Symfony\Security\SymfonyPasswordEncoder;
use Faker\Generator;
use Faker\Provider\Base;

final class PasswordProvider extends Base
{
    private SymfonyPasswordEncoder $passwordEncoder;

    public function __construct(Generator $generator, SymfonyPasswordEncoder $passwordEncoder)
    {
        parent::__construct($generator);

        $this->passwordEncoder = $passwordEncoder;
    }

    public function securityPassword(string $plainPassword): string
    {
        return $this->passwordEncoder->encode($plainPassword);
    }
}
