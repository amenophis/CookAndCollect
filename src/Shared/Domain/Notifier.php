<?php

declare(strict_types=1);

namespace App\Shared\Domain;

interface Notifier
{
    public const TYPE_SUCCESS = 'success';
    public const TYPE_ERROR   = 'error';

    public function notify(string $type, string $message): void;
}
