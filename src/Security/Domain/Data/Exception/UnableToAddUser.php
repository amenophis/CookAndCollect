<?php

declare(strict_types=1);

namespace App\Security\Domain\Data\Exception;

class UnableToAddUser extends \Exception
{
    public function __construct(\Throwable $previous)
    {
        parent::__construct('Unable to add user', 0, $previous);
    }
}
