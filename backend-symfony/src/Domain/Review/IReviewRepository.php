<?php

declare(strict_types=1);

namespace App\Domain\Review;

interface IReviewRepository
{
    public function save(Review $domain): string;

    /**
     * @return Review[]
     */
    public function getAll(): array;

    public function getById(string $id): Review;

    public function remove(Review $domain): void;
}
