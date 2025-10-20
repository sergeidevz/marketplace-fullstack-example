<?php

declare(strict_types=1);

namespace App\Domain\Listing;

interface IListingRepository
{
    public function save(Listing $domain): string;

    /**
     * @return Listing[]
     */
    public function getAll(): array;

    public function getById(string $id): Listing;

    public function remove(Listing $domain): void;
}
