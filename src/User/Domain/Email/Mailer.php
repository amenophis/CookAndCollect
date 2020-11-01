<?php

declare(strict_types=1);

namespace App\User\Domain\Email;

interface Mailer
{
    public function send(Email $email): void;
}
