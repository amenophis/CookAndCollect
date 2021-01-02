<?php

declare(strict_types=1);

namespace App\Restaurant\Domain\UseCase\AUserWantsToShowHisAccount;

use App\Shared\Domain\UseCase\UseCaseHandler;
use Psr\Log\LoggerInterface;

class Handler implements UseCaseHandler
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
    public function __invoke(Input $input): Output
    {
        // TODO: Add use case logic
    }
}
