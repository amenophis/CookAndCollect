<?php

declare(strict_types=1);

namespace App\Restaurant\Domain\UseCase\AUserWantsToCreateARestaurant;

use App\Restaurant\Domain\Data\Exception\UnableToAddRestaurant;
use App\Restaurant\Domain\Data\Model\Restaurant;
use App\Restaurant\Domain\Data\Repository\Restaurants;
use App\Shared\Domain\Clock;
use App\Shared\Domain\IdGenerator;
use App\Shared\Domain\Notifier;
use App\Shared\Domain\UseCase\UseCaseHandler;
use Psr\Log\LoggerInterface;

class Handler implements UseCaseHandler
{
    private Restaurants $restaurants;
    private IdGenerator $idGenerator;
    private Clock $clock;
    private Notifier $notifier;
    private LoggerInterface $logger;

    public function __construct(Restaurants $restaurants, IdGenerator $idGenerator, Clock $clock, Notifier $notifier, LoggerInterface $logger)
    {
        $this->restaurants = $restaurants;
        $this->idGenerator = $idGenerator;
        $this->clock       = $clock;
        $this->notifier    = $notifier;
        $this->logger      = $logger;
    }

    public function __invoke(Input $input): void
    {
        try {
            $restaurant = Restaurant::register(
                $this->idGenerator->getNew(),
                $input->getRestaurantName(),
                $input->getOwnerId(),
                $this->clock->now()
            );
            $this->restaurants->add($restaurant);

            $this->notifier->notify(Notifier::TYPE_SUCCESS, 'Your restaurant is registered !');
        } catch (UnableToAddRestaurant $e) {
            $this->logger->error($e->getMessage(), ['exception' => $e]);
        }
    }
}
