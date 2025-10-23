<?php

declare(strict_types=1);

namespace App\Domain\Listing;

use App\Domain\Category\Category;
use App\Domain\User\User;

final class ListingFactory
{
    public static function create(
        ?string $id,
        string $title,
        string $description,
        Category $category,
        int $price,
        string $currency,
        string $location,
        ListingStatus $status,
        User $author,
    ): Listing {
        return new Listing(
            id: $id,
            title: $title,
            description: $description,
            category: $category,
            price: $price,
            currency: $currency,
            location: $location,
            status: $status,
            author: $author
        );
    }
}
