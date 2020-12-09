<?php

declare(strict_types=1);

namespace App\Security\Cli;

use App\Security\Domain\Data\Exception\UserDoesNotHaveAdministratorRole;
use App\Security\Domain\Data\Exception\UserNotFound;
use App\Security\Domain\UseCase\GrantUserAdministratorRole;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Messenger\MessageBusInterface;

class RevokeUserAdministratorRoleCommand extends Command
{
    private MessageBusInterface $useCaseBus;

    public function __construct(MessageBusInterface $useCaseBus)
    {
        $this->useCaseBus = $useCaseBus;
        parent::__construct();
    }

    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:security:revoke-user-admin-role';

    protected function configure(): void
    {
        $this
            ->setDescription('Revoke user administrator role')
            ->setHelp('This command allow to revoke administrator role to user')
            ->addArgument('user_email', InputArgument::REQUIRED, 'The user email address')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        /** @var string $userEmail */
        $userEmail = $input->getArgument('user_email');

        try {
            $this->useCaseBus->dispatch(new GrantUserAdministratorRole\Input($userEmail));
            $io->success("The user {$userEmail} has been demoted admin");
        } catch (UserNotFound | UserDoesNotHaveAdministratorRole $e) {
            $io->error($e->getMessage());

            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}
