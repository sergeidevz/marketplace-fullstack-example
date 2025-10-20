<?php

declare(strict_types=1);

namespace App\Domain\Category;

interface ICategoryRepository
{
    public function save(Category $domain): string;

    /**
     * @return Category[]
     */
    public function getAll(): array;

    public function getById(string $id): Category;

    public function remove(Category $domain): void;
}
