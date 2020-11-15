<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Symfony\Mailer;

use App\Shared\Domain\Email\Address;
use App\Shared\Domain\Email\Email;
use App\Shared\Domain\Email\Mailer;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address as SymfonyAddress;

class SymfonyMailer implements Mailer
{
    private MailerInterface $mailer;
    private string $noReplyAddress;
    private string $subjectPrefix;

    public function __construct(MailerInterface $mailer, string $noReplyAddress, string $subjectPrefix)
    {
        $this->mailer         = $mailer;
        $this->noReplyAddress = $noReplyAddress;
        $this->subjectPrefix  = $subjectPrefix;
    }

    public function send(Email $email): void
    {
        $email = (new TemplatedEmail())
            ->from($this->noReplyAddress)
            ->to(
                ...array_map(fn (Address $address) => new SymfonyAddress(
                    $address->getAddress(),
                    $address->getName()
                ), $email->getRecipients())
            )
            ->subject("{$this->subjectPrefix} - {$email->getSubject()}")
            ->htmlTemplate($email->getTemplate())
            ->context($email->getParams())
        ;

        $this->mailer->send($email);
    }
}
