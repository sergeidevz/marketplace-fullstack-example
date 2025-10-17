<?php

declare(strict_types=1);

namespace App\Domain;

interface IReviewRepository
{
    public function save(Review $domain);

    /**
     * @return Review[]
     */
    public function findAll(): array;

    public function findById(string $id): ?Review;

    public function remove(string $id);
}
