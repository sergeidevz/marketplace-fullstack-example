<?php

declare(strict_types=1);

namespace App\Application\DTO;

use App\Domain\Entity\Category;

final class CategoryDTO
{
    public function __construct(
        public readonly string $name,
        public readonly int $id,
    ) {
    }

    public static function fromDomain(Category $domain): self
    {
        $id = $domain->getId();

        if (!$id) {
            throw new \DomainException('Id should not be null');
        }

        return new self(
            id: $id,
            name: $domain->getName(),
        );
    }
}
