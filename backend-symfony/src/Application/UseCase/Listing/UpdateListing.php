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

        if (null !== $dto->title) {
            $foundListing->setTitle($dto->title);
        }
        if (null !== $dto->price) {
            $foundListing->setPrice($dto->price);
        }
        if (null !== $dto->description) {
            $foundListing->setDescription($dto->description);
        }
        if (null !== $dto->currency) {
            $foundListing->setCurrency($dto->currency);
        }
        if (null !== $dto->location) {
            $foundListing->setLocation($dto->location);
        }
        if (null !== $dto->status) {
            $foundListing->setStatus($dto->status);
        }
        if (null !== $dto->categoryId) {
            $category = $this->categoryService->getById($dto->categoryId);
            $foundListing->setCategory($category);
        }

        $this->listingService->update($foundListing);

        return $id;
    }
}
