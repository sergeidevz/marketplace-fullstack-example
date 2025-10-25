<?php

namespace App\Domain\Event;

use App\Domain\Entity\Category;

final class CategoryCreated
{
    public function __construct(
        private readonly Category $category,
    ) {
    }

    public function getCategory(): Category
    {
        return $this->category;
    }
}
