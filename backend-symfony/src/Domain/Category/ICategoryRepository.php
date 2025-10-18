<?php

declare(strict_types=1);

namespace App\Domain\Category;

interface ICategoryRepository
{
    public function save(Category $domain): void;

    /**
     * @return Category[]
     */
    public function getAll(): array;

    public function findById(string $id): ?Category;

    public function remove(Category $domain): void;
}
