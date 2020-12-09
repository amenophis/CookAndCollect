<?php

declare(strict_types=1);

namespace App\Restaurant\Domain\Data\Repository;

use App\Restaurant\Domain\Data\Exception\UnableToAddRestaurant;
use App\Restaurant\Domain\Data\Model\Restaurant;

interface Restaurants
{
    /**
     * @throws UnableToAddRestaurant
     */
    public function add(Restaurant $restaurant): void;
}
