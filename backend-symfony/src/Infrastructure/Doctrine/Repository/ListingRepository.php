<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Repository;

use App\Domain\RepositoryInterface\IListingRepository;
use App\Domain\Entity\Listing;
use App\Domain\Shared\NotFoundException;
use App\Infrastructure\Doctrine\Entity\Listing as EntityListing;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Listing>
 */
class ListingRepository extends ServiceEntityRepository implements IListingRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EntityListing::class);
    }

    public function remove(Listing $domain): void
    {
        $entity = $this->find($domain->getId());
        if (null === $entity) {
            throw new NotFoundException('Listing not found');
        }
        $this->getEntityManager()->remove($entity);
        $this->getEntityManager()->flush();
    }

    public function save(Listing $domain): string
    {
        if ($domain->getId()) {
            $e = $this->find($domain->getId());

            if (null === $e) {
                throw new NotFoundException('Listing not found');
            }
        } else {
            $e = EntityListing::fromDomain($domain);
        }

        $this->getEntityManager()->persist($e);
        $this->getEntityManager()->flush();

        $id = $e->getId();
        $str_id = $id->toRfc4122();

        return $str_id;
    }

    public function getById(string $id): Listing
    {
        /**
         * @var ?EntityListing $entity
         */
        $entity = $this->find($id);

        NotFoundException::throwIfNull($entity);

        return $entity->toDomain();
    }

    public function getAll(): array
    {
        /**
         * @var EntityListing[]
         */
        $entities = parent::findAll();
        $domains = array_map(fn (EntityListing $e) => $e->toDomain(), $entities);

        return $domains;
    }
}
