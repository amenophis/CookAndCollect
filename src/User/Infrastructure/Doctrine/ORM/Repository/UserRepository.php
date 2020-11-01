<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Doctrine\ORM\Repository;

use App\User\Domain\Data\Model\Exception\UserNotFound;
use App\User\Domain\Data\Model\User;
use App\User\Domain\Data\Repository\Users;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @template TEntityClass of object
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
}
