<?php

declare(strict_types=1);

namespace App\Domain\Category;

final class CategoryService
{
    public function __construct(
        private readonly ICategoryRepository $categoryRepository,
    ) {
    }

    public function create(Category $domain): string
    {
        $id = $this->categoryRepository->save($domain);
        return $id;
    }

    public function update(Category $domain): string
    {
        $id = $this->categoryRepository->save($domain);
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

    public function getById(string $id): Category
    {
        return $this->categoryRepository->getById($id);
    }
}
