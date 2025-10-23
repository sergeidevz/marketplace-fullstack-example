<?php

declare(strict_types=1);

namespace App\Application\UseCase\Category;

use App\Application\DTO\CategoryDTO;
use App\Domain\Entity\Category;
use App\Domain\Service\CategoryService;

final class GetAllCategories
{
    public function __construct(
        private readonly CategoryService $categoryService,
    ) {
    }

    /**
     * @return CategoryDTO[]
     */
    public function execute(): array
    {
        $domains = $this->categoryService->getAll();

        $dtos = array_map(
            fn (Category $domain) => CategoryDTO::fromDomain($domain),
            $domains
        );

        return $dtos;
    }
}
