<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CategoryTest extends WebTestCase
{
    public function testSomething(): void
    {

        // dump(self::getContainer());
        //  exit;
        $client = static::createClient();

        $crawler = $client->request('GET', '/api/categories/');

        $this->assertResponseIsSuccessful();
    }
}
