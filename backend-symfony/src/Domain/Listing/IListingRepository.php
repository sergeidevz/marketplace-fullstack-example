<?php

declare(strict_types=1);

namespace App\Domain;

interface IListingRepository
{
    public function save(Listing $domain);

    /**
     * @return Listing[]
     */
    public function findAll(): array;

    public function findById(string $id): ?Listing;

    public function remove(string $id);
}
