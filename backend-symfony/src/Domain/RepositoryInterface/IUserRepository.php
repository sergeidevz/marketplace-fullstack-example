<?php

declare(strict_types=1);

namespace App\Domain\RepositoryInterface;

use App\Domain\Entity\User;

interface IUserRepository
{
    public function create(User $domain): int;

    public function update(User $domain): int;

    /**
     * @return User[]
     */
    public function getAll(): array;

    public function getById(int $id): User;

    public function getByEmail(string $email): User;

    public function getByDisplayName(string $displayName): User;

    public function remove(User $domain): void;
}
