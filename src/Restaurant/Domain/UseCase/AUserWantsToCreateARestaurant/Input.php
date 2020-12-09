<?php

declare(strict_types=1);

namespace App\Restaurant\Domain\UseCase\AUserWantsToCreateARestaurant;

class Input
{
    private string $ownerId;
    private string $restaurantName;

    public function __construct(string $ownerId, string $restaurantName)
    {
        $this->ownerId        = $ownerId;
        $this->restaurantName = $restaurantName;
    }

    public function getOwnerId(): string
    {
        return $this->ownerId;
    }

    public function getRestaurantName(): string
    {
        return $this->restaurantName;
    }
}
