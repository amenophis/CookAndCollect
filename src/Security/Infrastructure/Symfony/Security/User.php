<?php

declare(strict_types=1);

namespace App\Security\Infrastructure\Symfony\Security;

use App\Security\Domain\Data\Model\User as DomainUser;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class User implements UserInterface, EquatableInterface
{
    private string $email;
    private ?string $password;
    private bool $admin;

    private function __construct()
    {
    }

    public function isEqualTo(UserInterface $user)
    {
        return $user->getUsername() === $this->getUsername();
    }

    public static function createFromUser(DomainUser $user): self
    {
        $self           = new self();
        $self->email    = $user->getEmail();
        $self->password = $user->getPassword();
        $self->admin    = $user->isAdmin();

        return $self;
    }

    /**
     * {@inheritdoc}
     */
    public function getRoles()
    {
        if (true === $this->admin) {
            return ['ROLE_ADMIN'];
        }

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
