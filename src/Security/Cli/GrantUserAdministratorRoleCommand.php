<?php

declare(strict_types=1);

namespace App\Security\Cli;

use App\Security\Domain\Data\Model\Exception\UserAlreadyHasAdministratorRole;
use App\Security\Domain\Data\Model\Exception\UserNotFound;
use App\Security\Domain\UseCase\RevokeUserAdministratorRole;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Messenger\MessageBusInterface;

class GrantUserAdministratorRoleCommand extends Command
{
    private MessageBusInterface $useCaseBus;

    public function __construct(MessageBusInterface $useCaseBus)
    {
        $this->useCaseBus = $useCaseBus;
        parent::__construct();
    }

    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:security:grant-user-admin-role';

    protected function configure(): void
    {
        $this
            ->setDescription('Grant user administrator role')
            ->setHelp('This command allow to grant administrator role to user')
            ->addArgument('user_email', InputArgument::REQUIRED, 'The user email address')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        /** @var string $userEmail */
        $userEmail = $input->getArgument('user_email');

        try {
            $this->useCaseBus->dispatch(new RevokeUserAdministratorRole\Input($userEmail));
            $io->success("The user {$userEmail} has been promoted admin");
        } catch (UserNotFound | UserAlreadyHasAdministratorRole $e) {
            $io->error($e->getMessage());

            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}
