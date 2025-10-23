<?php

declare(strict_types=1);

namespace App\Application\UseCase\Listing;

use App\Application\DTO\CreateListingDTO;
use App\Domain\Factory\ListingFactory;
use App\Domain\Service\CategoryService;
use App\Domain\Service\ListingService;
use App\Domain\Service\UserService;

final class CreateListing
{
    public function __construct(
        private readonly ListingService $listingService,
        private readonly CategoryService $categoryService,
        private readonly UserService $userService,
    ) {
    }

    public function execute(CreateListingDTO $dto): int
    {
        $category = $this->categoryService->getById($dto->categoryId);
        $user = $this->userService->getById($dto->authorId);

        $listing = ListingFactory::create(
            title: $dto->title,
            description: $dto->description,
            category: $category,
            author: $user,
            price: $dto->price,
            currency: $dto->currency,
            status: $dto->status,
            location: $dto->location
        );

        $id = $this->listingService->create($listing);

        return $id;
    }
}
