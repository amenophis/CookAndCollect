<?php

declare(strict_types=1);

namespace App\User\Domain\UseCase\AUserWantsToActivateHisAccount;

use App\Shared\Domain\Clock;
use App\Shared\Domain\Notifier;
use App\Shared\Domain\RandomGenerator;
use App\Shared\Domain\UseCase\UseCaseHandler;
use App\User\Domain\Data\Model\Exception\InvalidUserActivationToken;
use App\User\Domain\Data\Model\Exception\UserNotFound;
use App\User\Domain\Data\Repository\Users;
use App\User\Domain\PasswordEncoder;

class Handler implements UseCaseHandler
{
    private Users $users;
    private RandomGenerator $randomGenerator;
    private Clock $clock;
    private PasswordEncoder $passwordEncoder;
    private Notifier $notifier;

    public function __construct(Users $user, RandomGenerator $randomGenerator, Clock $clock, PasswordEncoder $passwordEncoder, Notifier $notifier)
    {
        $this->users           = $user;
        $this->randomGenerator = $randomGenerator;
        $this->clock           = $clock;
        $this->passwordEncoder = $passwordEncoder;
        $this->notifier        = $notifier;
    }

    public function __invoke(Input $input): void
    {
        try {
            $user = $this->users->get($input->getUserId());
            $user->activate(
                $input->getActivationToken(),
                $this->clock->now(),
                $this->passwordEncoder->encode($user, $input->getPlainPassword())
            );
        } catch (UserNotFound | InvalidUserActivationToken $e) {
        }

        $this->notifier->notify(Notifier::TYPE_SUCCESS, 'Your user is activated !');
    }
}
