<?php

declare(strict_types=1);

namespace App\Domain\Category;

final class CategoryFactory
{
    public static function create(string $name): Category
    {
        return new Category(name: $name);
    }
}
