<?php

namespace App\Application\DTO;

final class CreateListingDTO implements \JsonSerializable
{
    public string $title;

    public int $price;

    public string $description;

    public int $categoryId;

    public int $authorId;

    public string $currency;

    public string $location;

    public string $status;

    public function jsonSerialize(): mixed
    {
        return [
            'title' => $this->title,
            'price' => $this->price,
            'description' => $this->description,
            'categoryId' => $this->categoryId,
            'authorId' => $this->authorId,
            'currency' => $this->currency,
            'location' => $this->location,
            'status' => $this->status,
        ];
    }
}
