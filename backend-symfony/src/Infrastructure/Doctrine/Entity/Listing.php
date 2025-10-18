<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Entity;

use App\Infrastructure\Doctrine\Repository\ListingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: ListingRepository::class)]
class Listing
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    private ?Uuid $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\ManyToOne(inversedBy: 'listings')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Category $category = null;

    #[ORM\Column]
    private ?int $price = null;

    #[ORM\Column(length: 5)]
    private ?string $currency = null;

    #[ORM\Column(length: 55)]
    private ?string $location = null;

    #[ORM\Column(length: 55)]
    private ?string $status = null;

    /**
     * @var Collection<int, ListingImage>
     */
    #[ORM\OneToMany(targetEntity: ListingImage::class, mappedBy: 'listing', orphanRemoval: true)]
    private Collection $listingImages;

    public function __construct()
    {
        $this->listingImages = new ArrayCollection();
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function setId(Uuid $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency): static
    {
        $this->currency = $currency;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): static
    {
        $this->location = $location;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection<int, ListingImage>
     */
    public function getListingImages(): Collection
    {
        return $this->listingImages;
    }

    public function addListingImage(ListingImage $listingImage): static
    {
        if (!$this->listingImages->contains($listingImage)) {
            $this->listingImages->add($listingImage);
            $listingImage->setListing($this);
        }

        return $this;
    }

    public function removeListingImage(ListingImage $listingImage): static
    {
        if ($this->listingImages->removeElement($listingImage)) {
            // set the owning side to null (unless already changed)
            if ($listingImage->getListing() === $this) {
                $listingImage->setListing(null);
            }
        }

        return $this;
    }
}
