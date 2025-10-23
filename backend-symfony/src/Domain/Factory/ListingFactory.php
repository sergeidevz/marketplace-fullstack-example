<?php

declare(strict_types=1);

namespace App\Domain\Factory;

use App\Domain\Entity\Category;
use App\Domain\Entity\Listing;
use App\Domain\Entity\User;

final class ListingFactory
{
    public static function create(
        string $title,
        string $description,
        Category $category,
        int $price,
        string $currency,
        string $location,
        string $status,
        User $author,
    ): Listing {
        $listing = new Listing();

        $listing->setTitle($title);
        $listing->setDescription($description);
        $listing->setCategory($category);
        $listing->setPrice($price);
        $listing->setCurrency($currency);
        $listing->setLocation($location);
        $listing->setStatus($status);
        $listing->setAuthor($author);

        return $listing;
    }
}
