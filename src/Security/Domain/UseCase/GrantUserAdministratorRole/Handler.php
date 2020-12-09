<?php

declare(strict_types=1);

namespace App\Security\Domain\UseCase\GrantUserAdministratorRole;

use App\Security\Domain\Data\Exception\UserDoesNotHaveAdministratorRole;
use App\Security\Domain\Data\Exception\UserNotFound;
use App\Security\Domain\Data\Repository\Users;
use App\Shared\Domain\UseCase\UseCaseHandler;

class Handler implements UseCaseHandler
{
    private Users $users;

    public function __construct(Users $user)
    {
        $this->users = $user;
    }

    /**
     * @throws UserNotFound
     * @throws UserDoesNotHaveAdministratorRole
     */
    public function __invoke(Input $input): void
    {
        $user = $this->users->getByEmail($input->getUserEmail());
        $user->revokeAdministratorRole();
    }
}
