<?php

declare(strict_types=1);

namespace App\Domain\User;

use App\Domain\Listing\Listing;

interface IUserRepository
{
    public function save(Listing $domain): string;

    /**
     * @return User[]
     */
    public function findAll(): array;

    public function getById(string $id): User;

    public function getByEmail(string $email): User;

    public function getByDisplayName(string $displayName): User;

    public function remove(User $domain): void;
}
