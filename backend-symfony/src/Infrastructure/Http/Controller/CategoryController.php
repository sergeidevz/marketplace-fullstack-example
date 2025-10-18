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
use App\Domain\Category\CategoryNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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
    public function getById(string $id, GetCategoryById $useCase): JsonResponse
    {
        try {
            $category = $useCase->execute($id);

            return $this->json(['category' => $category]);
        } catch (CategoryNotFoundException) {
            // TODO: Create error handler
            return $this->json(['message' => 'not found']);
        }
    }

    #[Route('/', methods: ['POST'])]
    public function create(#[MapRequestPayload] CreateCategoryDTO $dto, CreateCategory $useCase): JsonResponse
    {
        $useCase->execute($dto);

        return $this->json(['message' => 'success']);
    }

    #[Route('/{id}', methods: ['PUT'])]
    public function update(string $id, #[MapRequestPayload] UpdateCategoryDTO $dto, UpdateCategory $useCase): JsonResponse
    {
        try {
            $useCase->execute($id, $dto);

            return $this->json(['message' => 'success']);
        } catch (NotFoundHttpException) {
            return $this->json(['message' => 'not found']);
        }
    }

    #[Route('/{id}', methods: ['DELETE'])]
    public function delete(string $id, RemoveCategory $useCase): JsonResponse
    {
        try {
            $useCase->execute($id);

            return $this->json(['message' => 'success']);
        } catch (CategoryNotFoundException) {
            return $this->json(['message' => 'not found']);
        }
    }
}
