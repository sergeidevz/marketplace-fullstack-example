<?php

declare(strict_types=1);

namespace App\Domain\Factory;

use App\Domain\Entity\User;

final class UserFactory
{
    public static function create(
        string $name,
        string $email,
        string $displayName,
        string $phone,
        string $location,
        string $language,
    ): User {
        $user = new User();

        $user->setDisplayName($displayName)
            ->setEmail($email)
            ->setLanguage($language)
            ->setLocation($location)
            ->setName($name)
            ->setPhone($phone);

        return $user;
    }
}
