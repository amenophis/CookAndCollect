<?php

declare(strict_types=1);

namespace App\Restaurant\Infrastructure\Doctrine\ORM\Repository;

use App\Restaurant\Domain\Data\Exception\UnableToAddRestaurant;
use App\Restaurant\Domain\Data\Model\Restaurant;
use App\Restaurant\Domain\Data\Repository\Restaurants;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\ORMInvalidArgumentException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Restaurant>
 */
class RestaurantRepository extends ServiceEntityRepository implements Restaurants
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Restaurant::class);
    }

    /**
     * {@inheritdoc}
     */
    public function add(Restaurant $restaurant): void
    {
        try {
            $this->_em->persist($restaurant);
        } catch (ORMInvalidArgumentException | ORMException $e) {
            throw new UnableToAddRestaurant($e);
        }
    }

    public function findByOwner(string $ownerId): ?Restaurant
    {
        return $this->_em->getRepository(Restaurant::class)->findOneBy([
            'ownerId' => $ownerId,
        ]);
    }

    public function updateName(string $restaurantId, string $name): void
    {
        $this->_em->getRepository(Restaurant::class)->createQueryBuilder('r')
            ->update()
            ->set('r.name', ':name')
            ->setParameter('name', $name)
            ->where('r.id = :id')
            ->setParameter('id', $restaurantId)
            ->getQuery()
            ->execute()
        ;
    }
}
