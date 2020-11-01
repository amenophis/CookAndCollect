<?php

declare(strict_types=1);

namespace App\User\Domain\Data\Repository;

use App\User\Domain\Data\Model\Exception\UserNotFound;
use App\User\Domain\Data\Model\User;

interface Users
{
    public function add(User $user): void;

    /**
     * @throws UserNotFound
     */
    public function get(string $userId): User;

    /**
     * @throws UserNotFound
     */
    public function getByActivationToken(string $activationToken): User;
}
