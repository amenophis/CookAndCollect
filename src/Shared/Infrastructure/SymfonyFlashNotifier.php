<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure;

use App\Shared\Domain\Notifier;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class SymfonyFlashNotifier implements Notifier
{
    private SessionInterface $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    public function notify(string $type, string $message): void
    {
        /** @var FlashBag $flashBag */
        $flashBag = $this->session->getBag('flashes');

        $flashBag->add($type, $message);
    }
}
