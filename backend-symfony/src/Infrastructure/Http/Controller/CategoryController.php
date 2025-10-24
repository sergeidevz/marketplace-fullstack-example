<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controller;

use App\Application\DTO\CreateCategoryDTO;
use App\Application\DTO\UpdateCategoryDTO;
use App\Application\UseCase\Category\CreateCategory;
use App\Application\UseCase\Category\GetAllCategories;
use App\Application\UseCase\Category\GetCategoryById;
use App\Application\UseCase\Category\RemoveCategory;
use App\Application\UseCase\Category\UpdateCategory;
use App\Domain\Shared\NotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/categories', format: 'json')]
final class CategoryController extends AbstractController
{
    #[Route('/', methods: ['GET'])]
    public function getAll(GetAllCategories $useCase): JsonResponse
    {
        $categories = $useCase->execute();

        return $this->json(compact('categories'));
    }

    #[Route('/{id}', methods: ['GET'])]
    public function getById(int $id, GetCategoryById $useCase): JsonResponse
    {
        try {
            $category = $useCase->execute($id);

            return $this->json(['category' => $category]);
        } catch (NotFoundException) {
            // TODO: Create error handler
            return $this->json(['message' => 'not found']);
        }
    }

    #[Route('/', methods: ['POST'])]
    public function create(#[MapRequestPayload] CreateCategoryDTO $dto, CreateCategory $useCase): JsonResponse
    {
        $id = $useCase->execute($dto);

        return $this->json(['id' => $id], Response::HTTP_CREATED);
    }

    #[Route('/{id}', methods: ['PUT'])]
    public function update(int $id, #[MapRequestPayload] UpdateCategoryDTO $dto, UpdateCategory $useCase): JsonResponse
    {
        try {
            $id = $useCase->execute($id, $dto);

            return $this->json(['id' => $id], 200);
        } catch (NotFoundHttpException) {
            return $this->json(['message' => 'not found'],
                Response::HTTP_NOT_FOUND);
        }
    }

    #[Route('/{id}', methods: ['DELETE'])]
    public function delete(int $id, RemoveCategory $useCase): JsonResponse
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
