<?php

namespace App\Tests\Controller;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;

class CategoryTest extends ApiTestCase
{
    public function testSomething(): void
    {
        $response = static::createClient()->request('GET', '/api/categories');
        $code = $response->getStatusCode();

        dd($code);

        $this->assertResponseIsSuccessful();
    }
}
