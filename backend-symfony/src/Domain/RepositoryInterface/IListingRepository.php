<?php

declare(strict_types=1);

namespace App\Domain\RepositoryInterface;

use App\Domain\Entity\Listing;

interface IListingRepository
{
    public function create(Listing $domain): int;

    public function update(Listing $domain): int;

    /**
     * @return Listing[]
     */
    public function getAll(): array;

    public function getById(string $id): Listing;

    public function remove(Listing $domain): void;
}
