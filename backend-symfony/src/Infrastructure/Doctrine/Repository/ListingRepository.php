<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Repository;

use App\Domain\Entity\Listing;
use App\Domain\RepositoryInterface\IListingRepository;
use App\Domain\Shared\NotFoundException;
use Doctrine\DBAL\ParameterType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NoResultException;

class ListingRepository implements IListingRepository
{
    public function __construct(
        private EntityManagerInterface $em,
    ) {
    }

    public function remove(Listing $domain): void
    {
        $qb = $this->em->createQueryBuilder();
        $q = $qb->delete(Listing::class, 'l')
            ->where('l.id = :id')
            ->setParameter('id', $domain->getId())
            ->getQuery();

        $q->execute();
    }

    public function update(Listing $domain): int
    {
        $qb = $this->em->createQueryBuilder();
        $qb->update(Listing::class, 'l')
            ->set('l.title', ':title')
            ->set('l.description', ':description')
            ->set('l.price', ':price')
            ->set('l.currency', ':currency')
            ->set('l.location', ':location')
            ->set('l.status', ':status')
            ->set('l.category', ':category')
            ->where('l.id = :id')
            ->setParameter('id', $domain->getId())
            ->setParameter('title', $domain->getTitle())
            ->setParameter('description', $domain->getDescription())
            ->setParameter('price', $domain->getPrice())
            ->setParameter('currency', $domain->getCurrency())
            ->setParameter('location', $domain->getLocation())
            ->setParameter('status', $domain->getStatus())
            ->setParameter('category', $domain->getCategory())
            ->getQuery()
            ->execute();

        return $domain->getId();
    }

    public function create(Listing $domain): int
    {
        $this->em->persist($domain);
        $this->em->flush();

        return $domain->getId();
    }

    public function getById(int $id): Listing
    {
        $qb = $this->em->createQueryBuilder();
        $q = $qb
            ->select('l')
            ->from(Listing::class, 'l')
            ->where('l.id = :id')
            ->setParameter('id', $id, ParameterType::INTEGER)
            ->getQuery();

        try {
            $listing = $q->getSingleResult();
        } catch (NoResultException) {
            throw new NotFoundException("Listing $id not found");
        }

        return $listing;
    }

    public function getAll(): array
    {
        $qb = $this->em->createQueryBuilder();
        $categories = $qb->select('l')
            ->from(Listing::class, 'l')
            ->getQuery()
            ->getResult();

        return $categories;
    }
}
