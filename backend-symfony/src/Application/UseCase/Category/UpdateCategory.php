<?php

declare(strict_types=1);

namespace App\Application\UseCase\Category;

use App\Application\DTO\UpdateCategoryDTO;
use App\Domain\Category\Category;
use App\Domain\Category\CategoryNotFoundException;
use App\Domain\Category\CategoryService;

final class UpdateCategory
{
    public function __construct(
        private readonly CategoryService $categoryService,
    ) {
    }

    public function execute(string $id, UpdateCategoryDTO $dto): void
    {
        $foundCategory = $this->categoryService->findById($id);

        if (null === $foundCategory) {
            throw new CategoryNotFoundException();
        }

        $name = $foundCategory->name;

        // TODO: Find a better way.
        if (null !== $dto->name) {
            $name = $dto->name;
        }

        $category = new Category(
            name: $name,
            id: $id
        );

        $this->categoryService->update($category);
    }
}
