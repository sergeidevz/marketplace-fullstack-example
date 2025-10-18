<?php

declare(strict_types=1);

namespace App\Tests\Integration;

use App\Domain\Category\Category;
use App\Domain\Category\ICategoryRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DependencyInjection\Container;

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
        $categories = [
            new Category(name: 'books', id: '123'),
        ];

        $categoryRepo = $this->createMock(ICategoryRepository::class);
        $categoryRepo->expects(self::once())
            ->method('getAll')->willReturn($categories);

        $this->container->set(ICategoryRepository::class, $categoryRepo);
        $this->client->request('GET', '/api/categories/');

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $object = json_decode($content, true);

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(200);
        $this->assertJson($content);

        $this->assertArrayHasKey('categories', $object);
        $this->assertIsArray($object["categories"]);
    }
}
