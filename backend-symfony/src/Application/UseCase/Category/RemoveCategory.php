<?php

declare(strict_types=1);

namespace App\Application\UseCase\Category;

use App\Domain\Service\CategoryService;

final class RemoveCategory
{
    public function __construct(
        private readonly CategoryService $categoryService,
    ) {
    }

    public function execute(int $id): void
    {
        $foundCategory = $this->categoryService->getById($id);

        $this->categoryService->remove($foundCategory);
    }
}
