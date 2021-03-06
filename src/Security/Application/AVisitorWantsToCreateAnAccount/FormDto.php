<?php

declare(strict_types=1);

namespace App\Security\Application\AVisitorWantsToCreateAnAccount;

use Symfony\Component\Validator\Constraints as Assert;

class FormDto
{
    /**
     * @Assert\NotBlank
     * @Assert\Length(min=2, max=64)
     */
    public ?string $firstname = null;

    /**
     * @Assert\NotBlank
     * @Assert\Length(min=2, max=64)
     */
    public ?string $lastname = null;

    /**
     * @Assert\NotBlank
     * @Assert\Email
     * @Assert\Length(max=255)
     */
    public ?string $email = null;
}
