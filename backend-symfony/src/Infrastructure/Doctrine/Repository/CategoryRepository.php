<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Repository;

use App\Domain\Category\Category;
use App\Domain\Category\ICategoryRepository;
use App\Domain\Shared\NotFoundException;
use App\Infrastructure\Doctrine\Entity\Category as CategoryEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

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
        // OPTIMIZE:
        $entity = $this->find($domain->id);
        $this->em->remove($entity);
        $this->em->flush();
    }

    public function save(Category $domain): string
    {
        if ($domain->id) {
            $e = $this->find($domain->id);
        } else {
            $e = new CategoryEntity();
        }

        if ($domain->name) {
            $e->setName($domain->name);
        }

        $this->em->persist($e);
        $this->em->flush();

        $id = $e->getId();
        $str_id = $id->toRfc4122();

        return $str_id;
    }

    public function getById(string $id): Category
    {
        /**
         * @var ?CategoryEntity $entity
         */
        $entity = $this->find($id);

        NotFoundException::throwIfNull($entity);

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
