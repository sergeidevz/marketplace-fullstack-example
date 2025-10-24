<?php

namespace App\Application\DTO;

final class UpdateListingDTO
{
    public ?string $title = null;

    public ?int $price = null;

    public ?string $description = null;

    public ?int $categoryId = null;

    public ?string $currency = null;

    public ?string $location = null;

    public ?string $status = null;
}
