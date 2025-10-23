<?php

declare(strict_types=1);

namespace App\Application\DTO;

use App\Domain\Entity\User;

final class UserDTO
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly string $email,
        public readonly string $displayName,
        public readonly string $phone,
        public readonly string $location,
        public readonly string $language,
    ) {
    }

    public static function fromDomain(User $domain): self
    {
        $id = $domain->getId();

        if (!$id) {
            throw new \DomainException('An id should not be null');
        }

        return new self(
            id: $id,
            name: $domain->getName(),
            email: $domain->getEmail(),
            displayName: $domain->getDisplayName(),
            phone: $domain->getPhone(),
            location: $domain->getLocation(),
            language: $domain->getLanguage(),
        );
    }
}
