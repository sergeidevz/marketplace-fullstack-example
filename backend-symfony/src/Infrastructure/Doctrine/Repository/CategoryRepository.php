<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Repository;

use App\Domain\Category\Category;
use App\Domain\Category\ICategoryRepository;
use App\Infrastructure\Doctrine\Entity\Category as CategoryEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

/**
 * @extends ServiceEntityRepository<CategoryEntity>
 */
class CategoryRepository extends ServiceEntityRepository implements ICategoryRepository
{
    public function __construct(ManagerRegistry $registry, private EntityManagerInterface $em)
    {
        parent::__construct($registry, CategoryEntity::class);
    }

    public function remove(Category $domain): void
    {
        // TODO: Check if id is present
        $this->em->remove(CategoryEntity::fromDomain($domain));
        $this->em->flush();
    }

    public function save(Category $domain): void
    {
        $e = new CategoryEntity()->setName($domain->name);

        if (null !== $domain->id) {
            $e->setId(Uuid::fromString($domain->id));
        }

        $this->em->persist($e);
        $this->em->flush();
    }

    public function findById(string $id): ?Category
    {
        /**
         * @var ?CategoryEntity $entity
         */
        $entity = $this->find($id);

        if (null === $entity) {
            return null;
        }

        return $entity->toDomain();
    }

    public function getAll(): array
    {
        /**
         * @var CategoryEntity[]
         */
        $entities = parent::findAll();
        $domains = array_map(fn (CategoryEntity $e) => $e->toDomain(), $entities);

        return $domains;
    }
}
