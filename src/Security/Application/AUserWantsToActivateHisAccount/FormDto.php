<?php

declare(strict_types=1);

namespace App\Security\Application\AUserWantsToActivateHisAccount;

use Symfony\Component\Validator\Constraints as Assert;

class FormDto
{
    /**
     * @Assert\NotBlank
     * @Assert\Length(min=8, max=64)
     */
    public string $plainPassword;
}
