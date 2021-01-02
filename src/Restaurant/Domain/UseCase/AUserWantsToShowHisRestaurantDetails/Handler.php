<?php

declare(strict_types=1);

namespace App\Restaurant\Domain\UseCase\AUserWantsToShowHisRestaurantDetails;

use App\Restaurant\Domain\Data\Repository\Restaurants;
use App\Shared\Domain\UseCase\UseCaseHandler;
use Psr\Log\LoggerInterface;

class Handler implements UseCaseHandler
{
    private Restaurants $restaurants;
    private LoggerInterface $logger;

    public function __construct(Restaurants $restaurants, LoggerInterface $logger)
    {
        $this->restaurants = $restaurants;
        $this->logger      = $logger;
    }
    public function __invoke(Input $input): Output
    {
        $restaurant = $this->restaurants->findByOwner($input->getUserId());

        return new Output($restaurant);
    }
}
