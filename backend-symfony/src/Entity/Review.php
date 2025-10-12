<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\ReviewRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReviewRepository::class)]
class Review
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $rating = null;

    #[ORM\Column(length: 255)]
    private ?string $content = null;

    #[ORM\ManyToOne(inversedBy: 'reviews')]
    private ?User $author = null;

    #[ORM\OneToOne(inversedBy: 'review')]
    private ?Listing $listing = null;

    public function getListing(): ?Listing
    {
        return $this->listing;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRating(): ?int
    {
        return $this->rating;
    }

    public function setRating(int $rating): static
    {
        $this->rating = $rating;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getAuthorId(): ?User
    {
        return $this->author;
    }

    public function setAuthorId(?User $author): static
    {
        $this->author = $author;

        return $this;
    }
}
