<?= "<?php\n"; ?>

declare(strict_types=1);

namespace <?= $namespace; ?>;

use App\Shared\Domain\UseCase\UseCaseHandler;
use Psr\Log\LoggerInterface;

class Handler implements UseCaseHandler
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
<?php if ($has_output): ?>
    public function __invoke(Input $input): Output
<?php else: ?>
    public function __invoke(Input $input): void
<?php endif; ?>
    {
        // TODO: Add use case logic
    }
}
