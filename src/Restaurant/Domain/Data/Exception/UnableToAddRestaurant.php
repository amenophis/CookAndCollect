<?php

declare(strict_types=1);

namespace App\Restaurant\Domain\Data\Exception;

class UnableToAddRestaurant extends \Exception
{
    public function __construct(\Throwable $previous)
    {
        parent::__construct('Unable to add restaurant', 0, $previous);
    }
}
