<?php

declare(strict_types=1);

namespace App\Security\Infrastructure\Symfony\Security;

use App\Security\Domain\Data\Model\User;
use App\Security\Domain\PasswordEncoder;
use App\Security\Infrastructure\Symfony\Security\User as InfraUser;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SymfonyPasswordEncoder implements PasswordEncoder
{
    private UserPasswordEncoderInterface $userPasswordEncoder;

    public function __construct(UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $this->userPasswordEncoder = $userPasswordEncoder;
    }

    public function encode(User $user, string $password): string
    {
        return $this->userPasswordEncoder->encodePassword(InfraUser::createFromUser($user), $password);
    }
}
