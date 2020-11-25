<?php

declare(strict_types=1);

namespace App\Security\Infrastructure\Symfony\Security;

use App\Security\Domain\PasswordEncoder;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

class SymfonyPasswordEncoder implements PasswordEncoder
{
    private EncoderFactoryInterface $encoderFactory;

    public function __construct(EncoderFactoryInterface $encoderFactory)
    {
        $this->encoderFactory = $encoderFactory;
    }

    public function encode(string $password): string
    {
        return $this->encoderFactory->getEncoder(User::class)->encodePassword($password, null);
    }
}
