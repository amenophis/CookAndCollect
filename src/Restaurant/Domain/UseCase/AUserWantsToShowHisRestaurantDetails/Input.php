<?php

declare(strict_types=1);

namespace App\Restaurant\Domain\UseCase\AUserWantsToShowHisRestaurantDetails;

class Input
{
    private string $userId;

    public function __construct(string $userId)
    {
        $this->userId = $userId;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }
}
