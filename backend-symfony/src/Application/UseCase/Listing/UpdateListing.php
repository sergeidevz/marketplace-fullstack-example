<?php

declare(strict_types=1);

namespace App\Application\UseCase\Listing;

use App\Application\DTO\UpdateListingDTO;
use App\Domain\Factory\ListingFactory;
use App\Domain\Service\CategoryService;
use App\Domain\Service\ListingService;

final class UpdateListing
{
    public function __construct(
        private readonly ListingService $listingService,
        private readonly CategoryService $categoryService,
    ) {
    }

    public function execute(string $id, UpdateListingDTO $dto): string
    {
        $foundListing = $this->listingService->getById($id);

        if ($dto->title) {
            $foundListing->setTitle($dto->title);
        }
        if ($dto->price) {
            $foundListing->setPrice($dto->price);
        }
        if ($dto->description) {
            $foundListing->setDescription($dto->description);
        }
        if ($dto->currency) {
            $foundListing->setCurrency($dto->currency);
        }
        if ($dto->location) {
            $foundListing->setLocation($dto->location);
        }
        if ($dto->status) {
            $foundListing->setStatus($dto->status);
        }
        if ($dto->categoryId) {
            $category = $this->categoryService->getById($dto->categoryId);
            $foundListing->setCategory($category);
        }

        $this->listingService->update($foundListing);

        return $id;
    }
}
