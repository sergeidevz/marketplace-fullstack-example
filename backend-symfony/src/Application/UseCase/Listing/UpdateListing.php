<?php

declare(strict_types=1);

namespace App\Application\UseCase\Listing;

use App\Application\DTO\UpdateListingDTO;
use App\Domain\Service\CategoryService;
use App\Domain\Service\ListingService;

final class UpdateListing
{
    public function __construct(
        private readonly ListingService $listingService,
        private readonly CategoryService $categoryService,
    ) {
    }

    public function execute(int $id, UpdateListingDTO $dto): int
    {
        $foundListing = $this->listingService->getById($id);

        if ($dto->title !== null) {
            $foundListing->setTitle($dto->title);
        }
        if ($dto->price !== null) {
            $foundListing->setPrice($dto->price);
        }
        if ($dto->description !== null) {
            $foundListing->setDescription($dto->description);
        }
        if ($dto->currency !== null) {
            $foundListing->setCurrency($dto->currency);
        }
        if ($dto->location !== null) {
            $foundListing->setLocation($dto->location);
        }
        if ($dto->status !== null) {
            $foundListing->setStatus($dto->status);
        }
        if ($dto->categoryId !== null) {
            $category = $this->categoryService->getById($dto->categoryId);
            $foundListing->setCategory($category);
        }

        $this->listingService->update($foundListing);

        return $id;
    }
}
