<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Symfony\Security;

use Symfony\Component\Security\Core\User\UserInterface;

class User implements UserInterface
{
    private string $email;
    private ?string $password;

    public static function createFromUser(\App\User\Domain\Data\Model\User $user): self
    {
        $self           = new self();
        $self->password = $user->getPassword();

        return $self;
    }

    /**
     * {@inheritdoc}
     */
    public function getRoles()
    {
        return ['ROLE_USER'];
    }

    /**
     * {@inheritdoc}
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * {@inheritdoc}
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getUsername()
    {
        return $this->email;
    }

    /**
     * {@inheritdoc}
     */
    public function eraseCredentials(): void
    {
        unset($this->password);
    }
}
