<?php

declare(strict_types=1);

namespace App\Restaurant\Domain\UseCase\AUserWantsToShowHisRestaurantDetails;

use App\Restaurant\Domain\Data\Model\Restaurant;

class Output
{
    private ?Restaurant $restaurant;

    public function __construct(?Restaurant $restaurant)
    {
        $this->restaurant = $restaurant;
    }

    public function getRestaurant(): ?Restaurant
    {
        return $this->restaurant;
    }
}
