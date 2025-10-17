<?php

declare(strict_types=1);

namespace App\Domain;

interface IListingPaymentRepository
{
    public function save(ListingPayment $domain);

    /**
     * @return ListingPayment[]
     */
    public function findAll(): array;

    public function findById(string $id): ?ListingPayment;

    public function findByListingId(string $id): ?ListingPayment;

    public function remove(string $id);
}
