<?php

declare(strict_types=1);

namespace App\Application\UseCase\Category;

use App\Application\DTO\CategoryDTO;
use App\Domain\Category\CategoryNotFoundException;
use App\Domain\Category\CategoryService;

final class GetCategoryById
{
    public function __construct(
        private readonly CategoryService $categoryService,
    ) {
    }

    public function execute(string $id): CategoryDTO
    {
        $domain = $this->categoryService->findById($id);

        if (null === $domain) {
           throw new CategoryNotFoundException();
        }

        return CategoryDTO::fromDomain($domain);
    }
}
