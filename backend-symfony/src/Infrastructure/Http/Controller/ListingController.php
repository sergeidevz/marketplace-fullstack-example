<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controller;

use App\Application\DTO\CreateListingDTO;
use App\Application\DTO\UpdateListingDTO;
use App\Application\UseCase\Listing\CreateListing;
use App\Application\UseCase\Listing\GetAllListings;
use App\Application\UseCase\Listing\GetListingById;
use App\Application\UseCase\Listing\RemoveListing;
use App\Application\UseCase\Listing\UpdateListing;
use App\Domain\Shared\NotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/listings', format: 'json')]
final class ListingController extends AbstractController
{
    #[Route('/', methods: ['GET'])]
    public function getAll(GetAllListings $useCase): JsonResponse
    {
        $listings = $useCase->execute();

        return $this->json(compact('listings'));
    }

    #[Route('/{id}', methods: ['GET'])]
    public function getById(string $id, GetListingById $useCase): JsonResponse
    {
        try {
            $listing = $useCase->execute($id);

            return $this->json(['listing' => $listing]);
        } catch (NotFoundException) {
            // TODO: Create error handler
            return $this->json(['message' => 'not found']);
        }
    }

    #[Route('/', methods: ['POST'])]
    public function create(#[MapRequestPayload] CreateListingDTO $dto, CreateListing $useCase): JsonResponse
    {
        $id = $useCase->execute($dto);

        return $this->json(['id' => $id], Response::HTTP_CREATED);
    }

    #[Route('/{id}', methods: ['PUT'])]
    public function update(string $id, #[MapRequestPayload] UpdateListingDTO $dto, UpdateListing $useCase): JsonResponse
    {
        try {
            $id = $useCase->execute($id, $dto);

            return $this->json(['id' => $id], 200);
        } catch (NotFoundException) {
            return $this->json(['message' => 'not found'],
                Response::HTTP_NOT_FOUND);
        }
    }

    #[Route('/{id}', methods: ['DELETE'])]
    public function delete(string $id, RemoveListing $useCase): JsonResponse
    {
        try {
            $useCase->execute($id);

            return $this->json(['message' => 'success']);
        } catch (NotFoundException) {
            return $this->json(['message' => 'not found'],
                Response::HTTP_NOT_FOUND);
        }
    }
}
