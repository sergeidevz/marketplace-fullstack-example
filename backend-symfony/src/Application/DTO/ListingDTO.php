<?php

declare(strict_types=1);

namespace App\Application\DTO;

use App\Domain\Entity\Listing;

final class ListingDTO
{
    public function __construct(
        public readonly int $id,
        public readonly string $title,
        public readonly string $description,
        public readonly CategoryDTO $category,
        public readonly int $price,
        public readonly string $currency,
        public readonly string $location,
        public readonly string $status,
        public readonly UserDTO $author,
    ) {
    }

    public static function fromDomain(Listing $domain): self
    {
        $id = $domain->getId();

        if (!$id) {
            throw new \DomainException('An id should not be null');
        }

        return new self(
            id: $id,
            title: $domain->getTitle(),
            description: $domain->getDescription(),
            category: CategoryDTO::fromDomain($domain->getCategory()),
            price: $domain->getPrice(),
            currency: $domain->getCurrency(),
            location: $domain->getLocation(),
            status: $domain->getStatus(),
            author: UserDTO::fromDomain($domain->getAuthor())
        );
    }
}
