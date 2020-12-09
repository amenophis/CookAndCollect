<?php

declare(strict_types=1);

namespace App\Security\Infrastructure\Symfony\Security;

use App\Security\Domain\Data\Model\User as DomainUser;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class User implements UserInterface, EquatableInterface
{
    private string $id;
    private string $email;
    private ?string $password;
    private bool $admin;

    public function __construct(string $id, string $email, string $password, bool $isAdmin)
    {
        $this->id       = $id;
        $this->email    = $email;
        $this->password = $password;
        $this->admin    = $isAdmin;
    }

    public function isEqualTo(UserInterface $user)
    {
        return $user->getUsername() === $this->getUsername();
    }

    public static function createFromUser(DomainUser $user): self
    {
        return new self(
            $user->getId(),
            $user->getEmail(),
            $user->getPassword(),
            $user->isAdmin()
        );
    }

    public function getId(): string
    {
        return $this->id;
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
    }
}
