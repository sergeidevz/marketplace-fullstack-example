<?php

declare(strict_types=1);

namespace App\Domain\RepositoryInterface;

use App\Domain\Entity\Category;

interface ICategoryRepository
{
    public function create(Category $domain): int;
    public function update(Category $domain): int;

    /**
     * @return Category[]
     */
    public function getAll(): array;

    public function getById(int $id): Category;

    public function remove(Category $domain): void;
}
