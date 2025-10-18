<?php

declare(strict_types=1);

namespace App\Application\UseCase\Category;

use App\Domain\Category\CategoryNotFoundException;
use App\Domain\Category\CategoryService;

final class RemoveCategory
{
    public function __construct(
        private readonly CategoryService $categoryService,
    ) {
    }

    public function execute(string $id): void
    {
        $foundCategory = $this->categoryService->findById($id);

        if (null === $foundCategory) {
            throw new CategoryNotFoundException();
        }

        $this->categoryService->remove($foundCategory);
    }
}
