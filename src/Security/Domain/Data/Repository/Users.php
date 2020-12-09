<?php

declare(strict_types=1);

namespace App\Security\Domain\Data\Repository;

use App\Security\Domain\Data\Exception\UnableToAddUser;
use App\Security\Domain\Data\Exception\UserNotFound;
use App\Security\Domain\Data\Model\User;

interface Users
{
    /**
     * @throws UnableToAddUser
     */
    public function add(User $user): void;

    /**
     * @throws UserNotFound
     */
    public function get(string $userId): User;

    /**
     * @throws UserNotFound
     */
    public function getByActivationToken(string $activationToken): User;

    /**
     * @throws UserNotFound
     */
    public function getByEmail(string $email): User;

    public function findByEmail(string $email): ?User;
}
