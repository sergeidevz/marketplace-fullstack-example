<?php

declare(strict_types=1);

namespace App\Application\UseCase\Listing;

use App\Application\DTO\ListingDTO;
use App\Domain\Entity\Listing;
use App\Domain\Service\ListingService;

final class GetAllListings
{
    public function __construct(
        private readonly ListingService $listingService,
    ) {
    }

    /**
     * @return ListingDTO[]
     */
    public function execute(): array
    {
        $domains = $this->listingService->getAll();

        $dtos = array_map(
            fn (Listing $domain) => ListingDTO::fromDomain($domain),
            $domains
        );

        return $dtos;
    }
}
