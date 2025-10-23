<?php

declare(strict_types=1);

namespace App\Domain\User;

final class UserFactory
{
    public static function create(
        ?string $id,
        string $name,
        string $email,
        string $display_name,
        ?string $phone,
        string $location,
        string $language,
    ): User {
        return new User(
            $id,
            $name,
            $email,
            $display_name,
            $phone,
            $location,
            $language,
        );
    }
}
