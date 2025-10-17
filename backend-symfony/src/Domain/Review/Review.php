<?php

declare(strict_types=1);

namespace App\Domain;

final class Review
{
    public function __construct(
        public readonly ?string $id,
        public readonly int $rating,
        public readonly string $content,
        public readonly User $author,
        public readonly Listing $listing,
    ) {
        // TODO: Add validations
    }
}
