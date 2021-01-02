<?php

declare(strict_types=1);

namespace App\Restaurant\Application\AUserWantsToUpdateHisRestaurantName;

use Symfony\Component\Validator\Constraints as Assert;

class FormDto
{
    /**
     * @Assert\NotBlank
     * @Assert\Length(min=2, max=64)
     */
    public ?string $restaurantName = null;
}
