<?php

declare(strict_types=1);

namespace App\Application\UseCase\Category;

use App\Application\DTO\UpdateCategoryDTO;
use App\Domain\Service\CategoryService;

final class UpdateCategory
{
    public function __construct(
        private readonly CategoryService $categoryService,
    ) {
    }

    public function execute(int $id, UpdateCategoryDTO $dto): int
    {
        $foundCategory = $this->categoryService->getById($id);

        // TODO: Find a better way.
        if (null !== $dto->name) {
            $foundCategory = $dto->name;
        }

        $id = $this->categoryService->update($foundCategory);

        return $id;
    }
}
