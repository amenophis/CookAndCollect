<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Symfony\Maker;

use Symfony\Bundle\MakerBundle\ConsoleStyle;
use Symfony\Bundle\MakerBundle\DependencyBuilder;
use Symfony\Bundle\MakerBundle\Exception\RuntimeCommandException;
use Symfony\Bundle\MakerBundle\Generator;
use Symfony\Bundle\MakerBundle\InputConfiguration;
use Symfony\Bundle\MakerBundle\Maker\AbstractMaker;
use Symfony\Bundle\MakerBundle\Util\ClassNameDetails;
use Symfony\Bundle\MakerBundle\Validator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Question\Question;

class UseCaseMaker extends AbstractMaker
{
    private string $projectDir;
    private Generator $generator;

    public function __construct(string $projectDir, Generator $generator)
    {
        $this->projectDir = $projectDir;
        $this->generator  = $generator;
    }

    public static function getCommandName(): string
    {
        return 'make:cnc:use-case';
    }

    public function configureCommand(Command $command, InputConfiguration $inputConfig): void
    {
        $command->setDescription('Creates a use case in the context of your choice');
    }

    public function configureDependencies(DependencyBuilder $dependencies): void
    {
    }

    public function interact(InputInterface $input, ConsoleStyle $io, Command $command): void
    {
        $command->addArgument('context-name', InputArgument::REQUIRED);
        $questionContextName = new Question('The context in which the use case will be created (e.g. <fg=yellow>Shared, Security, etc ...</>)', 'Restaurant');
        $questionContextName->setValidator(
            function ($answer) {
                Validator::notBlank($answer);

                $context = $this->getContextPath($answer);

                if (!is_dir($context)) {
                    throw new RuntimeCommandException("The path {$context} doesn\'t exists.");
                }

                return $answer;
            }
        );
        $input->setArgument('context-name', $io->askQuestion($questionContextName));

        $command->addArgument('use-case-name', InputArgument::REQUIRED);
        $questionUseCaseNamespace = new Question('The use case name (e.g. <fg=yellow>AUserWantsToDoSomething</>)', 'AUserWantsToSayHello');
        $questionUseCaseNamespace->setValidator(
            function ($answer) use ($input) {
                Validator::notBlank($answer);

                $contextName = $input->getArgument('context-name');
                Validator::classDoesNotExist(
                    $this->getHandlerClassNameDetails($contextName, $answer)->getFullName()
                );

                return $answer;
            }
        );
        $input->setArgument('use-case-name', $io->askQuestion($questionUseCaseNamespace));

        $command->addArgument('use-case-has-output', InputArgument::REQUIRED);
        $questionUseCaseOutput = new Question('Do you need an Output for this use case ?', 'yes');
        $questionUseCaseOutput->setValidator(
            function ($answer) use ($input) {
                if (false === Validator::validateBoolean($answer)) {
                    return false;
                }

                $contextName = $input->getArgument('context-name');
                $useCaseName = $input->getArgument('use-case-name');
                Validator::classDoesNotExist($this->getOutputClassNameDetails($contextName, $useCaseName)->getFullName());

                return $answer;
            }
        );
        $input->setArgument('use-case-has-output', $io->askQuestion($questionUseCaseOutput));
    }

    public function generate(InputInterface $input, ConsoleStyle $io, Generator $generator): void
    {
        $contextName      = $input->getArgument('context-name');
        $useCaseName      = $input->getArgument('use-case-name');
        $useCaseHasOutput = $input->getArgument('use-case-has-output');

        $generator->generateClass(
            $this->getHandlerClassNameDetails($contextName, $useCaseName)->getFullName(),
            $this->projectDir.'/templates/maker/UseCase/Handler.maker.php',
            [
                'has_output' => $useCaseHasOutput,
            ]
        );

        $generator->generateClass(
            $this->getInputClassNameDetails($contextName, $useCaseName)->getFullName(),
            $this->projectDir.'/templates/maker/UseCase/Input.maker.php'
        );

        if ($useCaseHasOutput) {
            $generator->generateClass(
                $this->getOutputClassNameDetails($contextName, $useCaseName)->getFullName(),
                $this->projectDir.'/templates/maker/UseCase/Output.maker.php'
            );
        }

        $generator->writeChanges();
    }

    private function getContextPath(string $contextName): string
    {
        return $this->projectDir."/src/{$contextName}/Domain/UseCase";
    }

    private function getContextUseCaseNamespace(string $contextName, string $useCaseName): string
    {
        return "{$contextName}\\Domain\\UseCase\\{$useCaseName}";
    }

    private function getHandlerClassNameDetails(string $contextName, string $useCaseName): ClassNameDetails
    {
        return $this->generator->createClassNameDetails('Handler', $this->getContextUseCaseNamespace($contextName, $useCaseName));
    }

    private function getInputClassNameDetails(string $contextName, string $useCaseName): ClassNameDetails
    {
        return $this->generator->createClassNameDetails('Input', $this->getContextUseCaseNamespace($contextName, $useCaseName));
    }

    private function getOutputClassNameDetails(string $contextName, string $useCaseName): ClassNameDetails
    {
        return $this->generator->createClassNameDetails('Output', $this->getContextUseCaseNamespace($contextName, $useCaseName));
    }
}
