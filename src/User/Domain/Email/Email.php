<?php

declare(strict_types=1);

namespace App\User\Domain\Email;

abstract class Email
{
    /**
     * @var Address[]
     */
    private array $recipients;
    private string $subject;
    private string $template;
    /**
     * @var mixed[]
     */
    private array $params;

    /**
     * @param Address[] $recipients
     * @param mixed[]   $params
     */
    public function __construct(array $recipients, string $subject, string $template, array $params = [])
    {
        $this->recipients = $recipients;
        $this->subject    = $subject;
        $this->template   = $template;
        $this->params     = $params;
    }

    public function from(): Address
    {
        return new Address('no-reply@cook-and-collect.com', 'Cook and Collect');
    }

    /**
     * @return Address[]
     */
    public function getRecipients(): array
    {
        return $this->recipients;
    }

    public function getSubject(): string
    {
        return $this->subject;
    }

    public function getTemplate(): string
    {
        return $this->template;
    }

    /**
     * @return mixed[]
     */
    public function getParams(): array
    {
        return $this->params;
    }
}
