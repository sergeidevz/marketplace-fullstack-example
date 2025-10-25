<?php

declare(strict_types=1);

namespace App\Domain\Service;

use App\Domain\Entity\Category;
use App\Domain\Event\CategoryCreated;
use App\Domain\RepositoryInterface\ICategoryRepository;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

final class CategoryService
{
    public function __construct(
        private readonly ICategoryRepository $categoryRepository,
        private readonly EventDispatcherInterface $dispatcher,
    ) {
    }

    public function create(Category $domain): int
    {
        $id = $this->categoryRepository->create($domain);

        $this->dispatcher->dispatch(new CategoryCreated($domain));

        return $id;
    }

    public function update(Category $domain): int
    {
        $id = $this->categoryRepository->update($domain);

        return $id;
    }

    public function remove(Category $domain): void
    {
        $this->categoryRepository->remove($domain);
    }

    /**
     * @return Category[]
     */
    public function getAll(): array
    {
        return $this->categoryRepository->getAll();
    }

    public function getById(int $id): Category
    {
        return $this->categoryRepository->getById($id);
    }
}
