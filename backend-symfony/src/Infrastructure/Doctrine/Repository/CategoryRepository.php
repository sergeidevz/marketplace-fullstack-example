<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Repository;

use App\Domain\Entity\Category;
use App\Domain\RepositoryInterface\ICategoryRepository;
use App\Domain\Shared\NotFoundException;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;

class CategoryRepository implements ICategoryRepository
{
    private QueryBuilder $qb;

    public function __construct(
        private EntityManagerInterface $em,
    ) {
        $this->qb = $em->createQueryBuilder();
    }

    public function remove(Category $domain): void
    {
        $q = $this->qb->delete(Category::class, 'c')
            ->where('c.id = :id')
            ->setParameter('id', $domain->getId())
            ->getQuery();

        $q->getResult();
    }

    public function update(Category $domain): int
    {
        $this->qb->update(Category::class, 'c')
            ->set('c.name', ':name')
            ->where('c.id = :id')
            ->setParameter('id', $domain->getId())
            ->setParameter('name', $domain->getName())
            ->getQuery()
            ->getResult();

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
        $category = $this->qb
            ->select('c')
            ->from(Category::class, 'c')
            ->where('id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();

        NotFoundException::throwIfNull($category);

        return $category;
    }

    public function getAll(): array
    {
        $categories = $this->qb->select('c')
            ->from(Category::class, 'c')
            ->getQuery()
            ->getResult();

        return $categories;
    }
}
