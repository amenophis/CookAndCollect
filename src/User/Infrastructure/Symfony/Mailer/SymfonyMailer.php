<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Symfony\Mailer;

use App\User\Domain\Email\Address;
use App\User\Domain\Email\Email;
use App\User\Domain\Email\Mailer;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address as SymfonyAddress;

class SymfonyMailer implements Mailer
{
    private MailerInterface $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function send(Email $email): void
    {
        $email = (new TemplatedEmail())
            ->from('no-reply@cook-and-collect.com')
            ->to(
                ...array_map(fn (Address $address) => new SymfonyAddress(
                    $address->getAddress(),
                    $address->getName()
                ), $email->getRecipients())
            )
            ->subject($email->getSubject())
            ->htmlTemplate($email->getTemplate())
            ->context($email->getParams())
        ;

        $this->mailer->send($email);
    }
}
