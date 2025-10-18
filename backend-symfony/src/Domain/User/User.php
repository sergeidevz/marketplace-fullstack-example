<?php

declare(strict_types=1);

namespace App\Domain\User;

final class User
{
    public function __construct(
        public readonly ?string $id,
        public readonly string $name,
        public readonly string $email,
        public readonly string $display_name,
        public readonly ?string $phone,
        public readonly string $location,
        public readonly string $language,
    ) {
        // TODO: Add validations
    }
}
