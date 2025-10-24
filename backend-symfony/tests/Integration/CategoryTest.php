<?php

declare(strict_types=1);

namespace App\Tests\Integration;

use App\Domain\Factory\CategoryFactory;
use App\Domain\RepositoryInterface\ICategoryRepository;
use App\Domain\Shared\NotFoundException;
use Faker\Factory;
use Faker\Generator;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

class CategoryTest extends WebTestCase
{
    private KernelBrowser $client;
    private Generator $faker;
    private ICategoryRepository $categoryRepository;
    private string $path = '/api/categories/';

    protected function setUp(): void
    {
        parent::setUp();

        $this->faker = Factory::create();
        $this->client = static::createClient();
        $this->categoryRepository = static::getContainer()->get(ICategoryRepository::class);
    }


    public function testUpdateCategory()
    {
        // Arrange
        $category = CategoryFactory::create('cars');
        $id = $this->categoryRepository->create($category);

        $update = ['name' => 'books'];
        $json_string = json_encode($update);

        // Act
        $this->client->request(
            method: Request::METHOD_PUT,
            uri: $this->path.$id,
            server: ['CONTENT_TYPE' => 'application/json'],
            content: $json_string
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $decoded = json_decode($content, true);

        // Assert
        $updated = $this->categoryRepository->getById($id);
        $this->assertEquals('books', $updated->getName());
        $this->assertResponseStatusCodeSame(200);
        $this->assertEquals($decoded['id'], $id);
    }

    public function testCreateCategory()
    {
        // Arrange
        $category = ['name' => 'books'];
        $json_string = json_encode($category);

        // Act
        $old = $this->categoryRepository->getAll();
        $this->assertEquals(0, count($old));

        $this->client->request(
            method: Request::METHOD_POST,
            uri: $this->path,
            content: $json_string,
            server: ['CONTENT_TYPE' => 'application/json']
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $decoded = json_decode($content, true);

        // Assert
        $new = $this->categoryRepository->getAll();
        $this->assertCount(1, $new);
        $this->assertResponseStatusCodeSame(201);
        $this->assertEquals($decoded['id'], $new[0]->getId());
    }

    public function testGetCategories()
    {
        // Arrange
        $name = $this->faker->colorName();

        $category1 = CategoryFactory::create($name);
        $category2 = CategoryFactory::create($name);
        $category3 = CategoryFactory::create($name);

        $this->categoryRepository->create($category1);
        $this->categoryRepository->create($category2);
        $this->categoryRepository->create($category3);

        // Act
        $this->client->request(Request::METHOD_GET, $this->path);

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $json = json_decode($content, true);

        // Assert
        $actual = count($json['categories']);
        $expected = 3;
        // TODO: Assert schema

        $this->assertEquals($actual, $expected);
        $this->assertResponseStatusCodeSame(200);
    }

    public function testGetCategoryByIdSuccess()
    {
        // Arrange
        $name = $this->faker->colorName();

        $category = CategoryFactory::create($name);

        $id = $this->categoryRepository->create($category);
        $this->assertNotNull($id);

        // Act
        $this->client->request(Request::METHOD_GET, $this->path.$id);

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $json = json_decode($content, true);

        // Assert
        $this->assertResponseStatusCodeSame(200);
        $this->assertNotNull($json['category']);
    }

    public function testDeleteCategory()
    {
        // Arrange
        $id = $this->categoryRepository->create(CategoryFactory::create('books'));

        $found = $this->categoryRepository->getById($id);
        $this->assertEquals($id, $found->getId());

        // Act
        $this->client->request(Request::METHOD_DELETE, $this->path.$id);

        $this->expectException(NotFoundException::class);
        $this->categoryRepository->getById($id);

        // Assert
        $this->assertResponseStatusCodeSame(200);
    }
}
