<?php

namespace App\Application\DTO;

use Symfony\Component\Validator\Constraints as Assert;

final class CreateListingDTO
{
    #[Assert\NotBlank]
    #[Assert\Length(min: 5, max: 10)]
    public string $title;

    #[Assert\Range(min: 3)]
    public int $price;

    public string $description;

    public int $categoryId;

    public int $authorId;

    #[Assert\NotBlank]
    #[Assert\Length(min: 3, max: 4)]
    public string $currency;

    public string $location;

    public string $status;
}
