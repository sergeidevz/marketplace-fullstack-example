<?php

declare(strict_types=1);

namespace App\Domain;

interface IUserRepository
{
    public function save(Listing $domain);

    /**
     * @return User[]
     */
    public function findAll(): array;

    public function findById(string $id): ?User;

    public function findByEmail(string $email): ?User;

    public function findByDisplayName(string $displayName): ?User;

    public function remove(string $id);
}
