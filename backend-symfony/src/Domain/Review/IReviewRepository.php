<?php

declare(strict_types=1);

namespace App\Domain;

interface IReviewRepository
{
    public function save(Review $domain): void;

    /**
     * @return Review[]
     */
    public function findAll(): array;

    public function findById(string $id): ?Review;

    public function remove(Review $domain): void;
}
