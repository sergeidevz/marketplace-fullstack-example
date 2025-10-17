<?php

declare(strict_types=1);

namespace App\Domain;

final class Listing
{
    public function __construct(
        public readonly ?string $id,
        public readonly string $title,
        public readonly string $description,
        public readonly Category $category,
        public readonly int $price,
        public readonly string $currency,
        public readonly string $location,
        public readonly ListingStatus $status,
        public readonly User $author
    ) {
        if (empty($title)) {
            throw new \DomainException('Title should not be empty');
        }

        if ($price < 0) {
            throw new \DomainException('Price should not be negative');
        }
    }
}
