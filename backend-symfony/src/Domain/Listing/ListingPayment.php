<?php

declare(strict_types=1);

namespace App\Domain\Listing;

final class ListingPayment
{
    public function __construct(
        public readonly ?string $id,
        public readonly int $amount,
        public readonly string $status,
        public readonly string $provider,
        public readonly Listing $listing,
    ) {
        // TODO: Status enum
        // TODO: Add validation
    }
}
