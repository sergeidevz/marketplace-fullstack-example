<?php

declare(strict_types=1);

namespace App\Controller;

use App\Controller\DTO\CreateCategoryDTO;
use App\Controller\DTO\UpdateCategoryDTO;
use App\Entity\Category;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Uid\Uuid;

#[Route('/api/categories', format: 'json')]
final class CategoryController extends AbstractController
{
    public function __construct(
        private CategoryRepository $categoryRepository,
        private EntityManagerInterface $entityManager,
    ) {
    }

    #[Route('/', methods: ['GET'])]
    public function getAll(): JsonResponse
    {
        $categories = $this->categoryRepository->findAll();

        return $this->json(compact('categories'));
    }

    #[Route('/{id}', methods: ['GET'])]
    public function getById(Uuid $id): JsonResponse
    {
        $category = $this->categoryRepository->find($id);
        if (!$category) {
            throw $this->createNotFoundException();
        }

        return $this->json(['category' => $category]);
    }

    #[Route('/', methods: ['POST'])]
    public function create(#[MapRequestPayload] CreateCategoryDTO $dto): JsonResponse
    {
        $category = new Category()->setName($dto->name);

        $this->entityManager->persist($category);
        $this->entityManager->flush();

        return $this->json(['category' => $category]);
    }

    #[Route('/{id}', methods: ['PUT'])]
    public function update(Uuid $id, #[MapRequestPayload] UpdateCategoryDTO $dto): JsonResponse
    {
        $foundCategory = $this->categoryRepository->find($id);
        if (!$foundCategory) {
            throw $this->createNotFoundException();
        }

        $foundCategory->setName($dto->name);
        $this->entityManager->persist($foundCategory);
        $this->entityManager->flush();

        return $this->json(['category' => $foundCategory]);
    }

    #[Route('/{id}', methods: ['DELETE'])]
    public function delete(string $id): JsonResponse
    {
        $category = $this->categoryRepository->find($id);
        if (!$category) {
            throw $this->createNotFoundException();
        }

        $this->entityManager->remove($category);
        $this->entityManager->flush();

        return $this->json(['message' => 'success']);
    }
}
