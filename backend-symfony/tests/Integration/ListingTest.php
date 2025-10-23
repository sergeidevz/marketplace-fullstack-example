<?php

declare(strict_types=1);

namespace App\Tests\Integration;

use App\Domain\Category\CategoryFactory;
use App\Domain\Listing\IListingRepository;
use App\Domain\Listing\Listing;
use App\Domain\Listing\ListingFactory;
use App\Domain\Listing\ListingStatus;
use App\Domain\Shared\NotFoundException;
use App\Domain\User\UserFactory;
use Faker\Factory;
use Faker\Generator;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

class ListingTest extends WebTestCase
{
    private KernelBrowser $client;
    private Generator $faker;
    private IListingRepository $listingRepository;
    private string $path = '/api/listings/';

    protected function setUp(): void
    {
        parent::setUp();

        $this->faker = Factory::create();
        $this->client = static::createClient();
        $this->listingRepository = static::getContainer()->get(IListingRepository::class);
    }

    public function testGetListings()
    {
        // Arrange
        $listing = $this->generateListing();

        $this->listingRepository->save($listing);

        // Act
        $this->client->request(Request::METHOD_GET, $this->path);

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $json = json_decode($content, true);

        // Assert
        $actual = count($json['listings']);
        $expected = 1;
        // TODO: Assert schema

        $this->assertEquals($actual, $expected);
        $this->assertResponseStatusCodeSame(200);
    }

    public function testDeleteListing()
    {
        // Arrange
        $listing = $this->generateListing();
        $id = $this->listingRepository->save($listing);

        $found = $this->listingRepository->getById($id);
        $this->assertEquals($id, $found->id);

        // Act
        $this->client->request(Request::METHOD_DELETE, $this->path.$id);

        $this->expectException(NotFoundException::class);
        $this->listingRepository->getById($id);

        // Assert
        $this->assertResponseStatusCodeSame(200);
    }

    public function testUpdateListing()
    {
        // Arrange
        $listing = $this->generateListing();
        $id = $this->listingRepository->save($listing);

        $expected_new_title = 'new-title';
        $update = ['title' => $expected_new_title];
        $json_string = json_encode($update);

        // Act
        $this->client->request(
            method: Request::METHOD_PUT,
            uri: $this->path.$id,
            content: $json_string,
            server: ['CONTENT_TYPE' => 'application/json']
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $decoded = json_decode($content, true);

        // Assert
        $updated = $this->listingRepository->getById($id);
        $this->assertEquals($expected_new_title, $updated->title);
        $this->assertResponseStatusCodeSame(200);
        $this->assertEquals($decoded['id'], $id);
    }

    public function testCreateListing()
    {
        // Arrange
        $listing = ['name' => 'books'];
        $json_string = json_encode($listing);

        // Act
        $old = $this->listingRepository->getAll();
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
        $new = $this->listingRepository->getAll();
        $this->assertEquals(1, count($new));
        $this->assertResponseStatusCodeSame(201);
        $this->assertEquals($decoded['id'], $new[0]->id);
    }

    private function generateListing(): Listing
    {
        $user = UserFactory::create(
            name: $this->faker->name(),
            email: $this->faker->email(),
            display_name: $this->faker->name(),
            phone: $this->faker->phoneNumber(),
            location: $this->faker->address(),
            language: 'en',
            id: null
        );

        $category = CategoryFactory::create('books');

        $listing = ListingFactory::create(
            id: null,
            title: $this->faker->jobTitle(),
            description: $this->faker->text(100),
            category: $category,
            price: 500,
            currency: 'eur',
            location: $this->faker->address(),
            status: ListingStatus::Published,
            author: $user
        );

        return $listing;
    }

    public function testGetListingByIdSuccess()
    {
        // Arrange
        $listing = $this->generateListing();

        $id = $this->listingRepository->save($listing);
        $this->assertNotNull($id);

        // Act
        $this->client->request(Request::METHOD_GET, $this->path.$id);

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $json = json_decode($content, true);

        // Assert
        $this->assertResponseStatusCodeSame(200);
        $this->assertNotNull($json['listing']);
    }
}
