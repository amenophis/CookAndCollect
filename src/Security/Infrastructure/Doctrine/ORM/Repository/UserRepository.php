<?php

declare(strict_types=1);

namespace App\Security\Infrastructure\Doctrine\ORM\Repository;

use App\Security\Domain\Data\Model\Exception\UserNotFound;
use App\Security\Domain\Data\Model\User;
use App\Security\Domain\Data\Repository\Users;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<User>
 */
class UserRepository extends ServiceEntityRepository implements Users
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * {@inheritdoc}
     */
    public function add(User $user): void
    {
        $this->_em->persist($user);
    }

    /**
     * {@inheritdoc}
     */
    public function get(string $userId): User
    {
        /** @var ?User $user */
        $user = $this->find($userId);
        if (null === $user) {
            throw UserNotFound::byId($userId);
        }

        return $user;
    }

    /**
     * {@inheritdoc}
     */
    public function getByActivationToken(string $activationToken): User
    {
        /** @var ?User $user */
        $user = $this->findOneBy(['activation_token' => $activationToken]);
        if (null === $user) {
            throw UserNotFound::byActivationToken($activationToken);
        }

        return $user;
    }

    public function getByEmail(string $email): User
    {
        /** @var ?User $user */
        $user = $this->findOneBy(['email' => $email]);
        if (null === $user) {
            throw UserNotFound::byEmail($email);
        }

        return $user;
    }
}
