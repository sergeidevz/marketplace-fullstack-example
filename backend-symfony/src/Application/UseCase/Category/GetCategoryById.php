<?php

declare(strict_types=1);

namespace App\Application\UseCase\Category;

use App\Application\DTO\CategoryDTO;
use App\Domain\Service\CategoryService;

final class GetCategoryById
{
    public function __construct(
        private readonly CategoryService $categoryService,
    ) {
    }

    public function execute(int $id): CategoryDTO
    {
        $domain = $this->categoryService->getById($id);

        return CategoryDTO::fromDomain($domain);
    }
}
