<?php

declare(strict_types=1);

namespace App\Security\Infrastructure\Symfony\Security;

use App\Security\Domain\Data\Exception\UserNotFound;
use App\Security\Domain\Data\Repository\Users;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserProvider implements UserProviderInterface
{
    private Users $userRepository;

    public function __construct(Users $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function loadUserByUsername(string $username)
    {
        try {
            return User::createFromUser(
                $this->userRepository->getByEmail($username)
            );
        } catch (UserNotFound $e) {
            throw new UsernameNotFoundException('Email could not be found.');
        }
    }

    public function refreshUser(UserInterface $user)
    {
        return $this->loadUserByUsername($user->getUsername());
    }

    public function supportsClass(string $class)
    {
        return User::class === $class;
    }
}
