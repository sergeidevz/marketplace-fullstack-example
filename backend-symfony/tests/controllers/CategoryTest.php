<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CategoryTest extends WebTestCase
{
    public function testSomething(): void
    {
        $client = static::createClient();
        $container = static::getContainer();

        $categoryRepo = $this->createMock(CategoryRepository::class);
        $categoryRepo->expects(self::once())
            ->method('findAll')
            ->willReturn([]);

        $container->set(CategoryRepository::class, $categoryRepo);

        $client->request('GET', '/api/categories/');

        $this->assertResponseIsSuccessful();
    }
}
