<?php

declare(strict_types=1);

namespace App\Application\UseCase\Category;

use App\Application\DTO\CreateCategoryDTO;
use App\Domain\Factory\CategoryFactory;
use App\Domain\Service\CategoryService;

final class CreateCategory
{
    public function __construct(
        private readonly CategoryService $categoryService,
    ) {
    }

    public function execute(CreateCategoryDTO $dto): int
    {
        $category = CategoryFactory::create($dto->name);

        $id = $this->categoryService->create($category);

        return $id;
    }
}
