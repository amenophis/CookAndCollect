<?php

declare(strict_types=1);

namespace App\Restaurant\Domain\UseCase\AUserWantsToUpdateHisRestaurantName;

use App\Restaurant\Domain\Data\Repository\Restaurants;
use App\Shared\Domain\Notifier;
use App\Shared\Domain\UseCase\UseCaseHandler;
use Psr\Log\LoggerInterface;

class Handler implements UseCaseHandler
{
    private Restaurants $restaurants;
    private Notifier $notifier;
    private LoggerInterface $logger;

    public function __construct(Restaurants $restaurants, Notifier $notifier, LoggerInterface $logger)
    {
        $this->restaurants = $restaurants;
        $this->notifier    = $notifier;
        $this->logger      = $logger;
    }

    public function __invoke(Input $input): void
    {
        $this->restaurants->updateName($input->getRestaurantId(), $input->getNewRestaurantName());
        $this->notifier->notify(Notifier::TYPE_SUCCESS, 'Le nom de votre restaurant a bien été pris en compte.');
    }
}
