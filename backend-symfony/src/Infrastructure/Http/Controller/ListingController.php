<?php

declare(strict_types=1);

namespace App\Controller;

use App\Controller\DTO\CreateListingDTO;
use App\Controller\DTO\UpdateListingDTO;
use App\Entity\Listing;
use App\Repository\CategoryRepository;
use App\Repository\ListingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Uid\Uuid;
use Symfony\Polyfill\Intl\Icu\Exception\NotImplementedException;

#[Route('/api/listings', format: 'json')]
final class ListingController extends AbstractController
{
    public function __construct(
        private ListingRepository $listingRepository,
        private EntityManagerInterface $entityManager,
    ) {
    }

    #[Route('/', methods: ['GET'])]
    public function getAll(): JsonResponse
    {
        $listings = $this->listingRepository->findAll();

        return $this->json([
            'listings' => $listings,
        ]);
    }

    #[Route('/{id}', methods: ['GET'])]
    public function getById(Uuid $id): JsonResponse
    {
        $listing = $this->listingRepository->find($id);
        if (!$listing) {
            throw $this->createNotFoundException();
        }

        return $this->json(['listing' => $listing]);
    }

    #[Route('/', methods: ['POST'])]
    public function create(#[MapRequestPayload] CreateListingDTO $dto): JsonResponse
    {
        $categoryRepo = $this->entityManager->getRepository(CategoryRepository::class);

        $foundCategory = $categoryRepo->find($dto->categoryId);

        if (!$foundCategory) {
            throw $this->createNotFoundException();
        }

        $listing = new Listing()
            ->setTitle($dto->title)
            ->setCategory($foundCategory)
        ;

        $this->entityManager->persist($listing);
        $this->entityManager->flush();

        return $this->json(['category' => $listing]);
    }

    #[Route('/', methods: ['PUT'])]
    public function update(Uuid $id, #[MapRequestPayload] UpdateListingDTO $dto): JsonResponse
    {
        throw new NotImplementedException("Not implemented");
        $foundListing = $this->listingRepository->find($id);

        if (!$foundListing) {
            throw new NotFoundHttpException();
        }

        $this->entityManager->persist($listing);
        $this->entityManager->flush();

        return $this->json(['category' => $listing]);
    }

    #[Route('/{id}', methods: ['DELETE'])]
    public function delete(string $id): JsonResponse
    {
        throw new NotImplementedException("Not implemented");

        return $this->json(['message' => 'success']);
    }
}
