<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table(name: 'listing')]
class Listing
{
    #[Id]
    #[Column]
    #[GeneratedValue]
    private int $id;

    #[Column]
    private string $title;

    #[Column]
    private string $description;

    #[ManyToOne(targetEntity: Category::class, inversedBy: 'listings', cascade: ['persist'])]
    private Category $category;

    #[Column]
    private int $price;

    #[Column]
    private string $currency;

    #[Column]
    private string $location;

    #[Column]
    private string $status;

    #[ManyToOne(targetEntity: User::class, inversedBy: 'listings', cascade: ['persist'])]
    private User $author;

    public function __construct(
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getCategory(): Category
    {
        return $this->category;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getLocation(): string
    {
        return $this->location;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getAuthor(): User
    {
        return $this->author;
    }

    // --- Setters ---

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function setCategory(Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function setCurrency(string $currency): self
    {
        $this->currency = $currency;

        return $this;
    }

    public function setLocation(string $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function setAuthor(User $author): self
    {
        $this->author = $author;

        return $this;
    }
}
