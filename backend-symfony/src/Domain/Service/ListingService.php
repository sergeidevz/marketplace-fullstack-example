<?php

declare(strict_types=1);

namespace App\Domain\Service;

use App\Domain\Entity\Listing;
use App\Domain\RepositoryInterface\IListingRepository;

final class ListingService
{
    public function __construct(
        private readonly IListingRepository $listingRepository,
    ) {
    }

    public function create(Listing $domain): int
    {
        $id = $this->listingRepository->create($domain);
        return $id;
    }

    public function update(Listing $domain): int
    {
        $id = $this->listingRepository->update($domain);
        return $id;
    }

    public function remove(Listing $domain): void
    {
        $this->listingRepository->remove($domain);
    }

    /**
     * @return Listing[]
     */
    public function getAll(): array
    {
        return $this->listingRepository->getAll();
    }

    public function getById(string $id): Listing
    {
        return $this->listingRepository->getById($id);
    }
}
