<?php

namespace App\Controller\DTO;

use Symfony\Component\Validator\Constraints as Assert;

final class CreateCategoryDTO
{
    #[Assert\NotBlank]
    public ?string $name;
}
