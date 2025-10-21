<?php

declare(strict_types=1);

namespace App\Application\UseCase\Category;

use App\Application\DTO\CreateCategoryDTO;
use App\Domain\Category\Category;
use App\Domain\Category\CategoryService;

final class CreateCategory
{
    public function __construct(
        private readonly CategoryService $categoryService,
    ) {
    }

    public function execute(CreateCategoryDTO $dto): string
    {
        $category = new Category(
            name: $dto->name
        );

        $id = $this->categoryService->create($category);
        return $id;
    }
}
