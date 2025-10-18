<?php

declare(strict_types=1);

namespace App\Domain\Category;

use App\Domain\Category\Category;
use App\Domain\Category\ICategoryRepository;

final class CategoryService
{
    public function __construct(
        private readonly ICategoryRepository $categoryRepository,
    ) {
    }

    public function create(Category $domain): void
    {
        $this->categoryRepository->save($domain);
    }

    public function update(Category $domain): void
    {
        $this->categoryRepository->save($domain);
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

    public function findById(string $id): ?Category
    {
        return $this->categoryRepository->findById($id);
    }
}
