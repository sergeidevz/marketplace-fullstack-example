<?php

declare(strict_types=1);

namespace App\Domain\Review;

use App\Domain\Listing\Listing;
use App\Domain\User\User;

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
