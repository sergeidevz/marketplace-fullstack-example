<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Uid\Uuid;

class CategoryTest extends WebTestCase
{
    private KernelBrowser $client;
    private Container $container;

    protected function setUp(): void
    {
        parent::setUp();

        $this->client = static::createClient();
        $this->container = static::getContainer();
    }

    public function testGetCategories(): void
    {
        $categoryRepo = $this->createMock(CategoryRepository::class);
        $categoryRepo->expects(self::once())
            ->method('findAll')
            ->willReturn([]);
        $this->container->set(CategoryRepository::class, $categoryRepo);
        $this->client->request('GET', '/api/categories/');
        $response = $this->client->getResponse();
        $content = $response->getContent();
        $object = json_decode($content, true);

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(200);
        $this->assertJson($content);

        $this->assertArrayHasKey('categories', $object);
    }

    public function testGetCategoryById(): void
    {
        $categoryRepo = $this->createMock(CategoryRepository::class);
        $categoryRepo->expects(self::once())
            ->method('find')
            ->willThrowException(new NotFoundHttpException());
        $this->container->set(CategoryRepository::class, $categoryRepo);
        $id = Uuid::v7();
        $this->client->request('GET', "/api/categories/$id");
        $this->assertResponseStatusCodeSame(404);
    }
}
