<?php

declare(strict_types=1);

namespace App\Application\UseCase\Listing;

use App\Application\DTO\ListingDTO;
use App\Domain\Service\ListingService;

final class GetListingById
{
    public function __construct(
        private readonly ListingService $listingService,
    ) {
    }

    public function execute(int $id): ListingDTO
    {
        $domain = $this->listingService->getById($id);

        return ListingDTO::fromDomain($domain);
    }
}
