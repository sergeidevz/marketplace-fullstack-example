<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use App\Repository\CategoryRepository;
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

        $categoryRepo = $this->createMock(CategoryRepository::class);
        $categoryRepo->expects(self::once())
            ->method('findAll')
            ->willReturn([]);

        $this->client = static::createClient();
        $this->container = static::getContainer();
        $this->container->set(CategoryRepository::class, $categoryRepo);
    }

    public function testGetCategories(): void
    {
        $this->client->request('GET', '/api/categories/');
        $response = $this->client->getResponse();
        $content = $response->getContent();
        $object = json_decode($content, true);

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(200);
        $this->assertJson($content);

        $this->assertArrayHasKey("categories", $object);
    }

}
