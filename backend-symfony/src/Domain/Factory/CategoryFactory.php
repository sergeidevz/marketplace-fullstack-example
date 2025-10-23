<?php

declare(strict_types=1);

namespace App\Domain\Factory;

use App\Domain\Entity\Category;

final class CategoryFactory
{
    public static function create(string $name): Category
    {
        $category = new Category();
        $category->setName($name);

        return $category;
    }
}
