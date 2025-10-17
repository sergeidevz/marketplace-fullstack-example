<?php

namespace App\Controller\DTO;

use Symfony\Component\Validator\Constraints as Assert;

final class UpdateCategoryDTO
{

    #[Assert\NotBlank]
    public ?string $name;
}
