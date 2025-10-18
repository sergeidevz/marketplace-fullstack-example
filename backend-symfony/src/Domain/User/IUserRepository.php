<?php

declare(strict_types=1);

namespace App\Domain\User;

use App\Domain\Listing\Listing;

interface IUserRepository
{
    public function save(Listing $domain): void;

    /**
     * @return User[]
     */
    public function findAll(): array;

    public function findById(string $id): ?User;

    public function findByEmail(string $email): ?User;

    public function findByDisplayName(string $displayName): ?User;

    public function remove(User $domain): void;
}
