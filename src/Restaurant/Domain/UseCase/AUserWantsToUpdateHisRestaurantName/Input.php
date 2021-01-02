<?php

declare(strict_types=1);

namespace App\Restaurant\Domain\UseCase\AUserWantsToUpdateHisRestaurantName;

class Input
{
    private string $restaurantId;
    private string $newRestaurantName;

    public function __construct(string $restaurantId, string $newRestaurantName)
    {
        $this->restaurantId      = $restaurantId;
        $this->newRestaurantName = $newRestaurantName;
    }

    public function getRestaurantId(): string
    {
        return $this->restaurantId;
    }

    public function getNewRestaurantName(): string
    {
        return $this->newRestaurantName;
    }
}
