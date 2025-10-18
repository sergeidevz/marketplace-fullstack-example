<?php

declare(strict_types=1);

namespace App\Domain\Listing;

interface IListingRepository
{
    public function save(Listing $domain): void;

    /**
     * @return Listing[]
     */
    public function findAll(): array;

    public function findById(string $id): ?Listing;

    public function remove(Listing $domain): void;
}
