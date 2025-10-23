<?php

declare(strict_types=1);

namespace App\Application\UseCase\Listing;

use App\Domain\Service\ListingService;

final class RemoveListing
{
    public function __construct(
        private readonly ListingService $listingService,
    ) {
    }

    public function execute(string $id): void
    {
        $foundListing = $this->listingService->getById($id);

        $this->listingService->remove($foundListing);
    }
}
