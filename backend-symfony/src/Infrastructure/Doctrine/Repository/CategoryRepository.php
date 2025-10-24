<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Repository;

use App\Domain\Entity\Category;
use App\Domain\RepositoryInterface\ICategoryRepository;
use App\Domain\Shared\NotFoundException;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NoResultException;

class CategoryRepository implements ICategoryRepository
{
    public function __construct(
        private readonly EntityManagerInterface $em,
    ) {
    }

    public function remove(Category $domain): void
    {
        $qb = $this->em->createQueryBuilder();
        $qb->delete(Category::class, 'c')
            ->where('c.id = :id')
            ->setParameter('id', $domain->getId())
            ->getQuery()
            ->execute();
    }

    public function update(Category $domain): int
    {
        $qb = $this->em->createQueryBuilder();
        $qb->update(Category::class, 'c')
            ->set('c.name', ':name')
            ->where('c.id = :id')
            ->setParameter('name', $domain->getName())
            ->setParameter('id', $domain->getId())
            ->getQuery()
            ->execute();

        return $domain->getId();
    }

    public function create(Category $domain): int
    {
        $this->em->persist($domain);
        $this->em->flush();

        return $domain->getId();
    }

    public function getById(int $id): Category
    {
        $qb = $this->em->createQueryBuilder();
        $q = $qb
            ->select('c')
            ->from(Category::class, 'c')
            ->where('c.id = :id')
            ->setParameter('id', $id)
            ->getQuery();

        try {
            $category = $q->getSingleResult();
        } catch (NoResultException) {
            throw new NotFoundException("Category $id not found");
        }


        return $category;
    }

    public function getAll(): array
    {
        $qb = $this->em->createQueryBuilder();
        $categories = $qb->select('c')
            ->from(Category::class, 'c')
            ->getQuery()
            ->getResult();

        return $categories;
    }
}
