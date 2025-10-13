<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/categories', format: "json")]
final class CategoryController extends AbstractController
{
    public function __construct(
        private CategoryRepository $categoryRepository,
    ) {
    }

    #[Route('/', methods: ['GET'])]
    public function getAll(): JsonResponse
    {
        $categories = $this->categoryRepository->findAll();

        return $this->json(compact('categories'), 201);
    }


    #[Route('/{id}', methods: ['GET'])]
    public function getById(string $id): JsonResponse
    {
        $category = $this->categoryRepository->findOneBy(["id", $id]);
        if (!$category) {
            throw $this->createNotFoundException();
        }

        return $this->json($id);
    }

    #[Route('/{id}', methods: ['PUT'])]
    public function update(string $id): JsonResponse
    {
        return $this->json($id);
    }

    #[Route("/{id}", methods: ["DELETE"])]
    public function delete(string $id): JsonResponse
    {
        $this->categoryRepository->createQueryBuilder('delete', 'd')
            ->delete('categories', 'c')
            ->where('id = :id')
            ->setParameter('id', $id);

        return $this->json('Deleted');
    }
}
