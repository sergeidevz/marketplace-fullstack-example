<?php

declare(strict_types=1);

namespace App\Tests\Integration;

use App\Application\DTO\CreateListingDTO;
use App\Domain\Entity\Category;
use App\Domain\Entity\Listing;
use App\Domain\Entity\User;
use App\Domain\Factory\CategoryFactory;
use App\Domain\Factory\ListingFactory;
use App\Domain\Factory\UserFactory;
use App\Domain\RepositoryInterface\ICategoryRepository;
use App\Domain\RepositoryInterface\IListingRepository;
use App\Domain\RepositoryInterface\IUserRepository;
use App\Domain\Shared\NotFoundException;
use Faker\Factory;
use Faker\Generator;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;

class ListingTest extends WebTestCase
{
    private KernelBrowser $client;
    private Generator $faker;
    private IListingRepository $listingRepository;
    private string $path = '/api/listings/';
    private SerializerInterface $serializer;

    protected function setUp(): void
    {
        parent::setUp();

        $this->faker = Factory::create();
        $this->client = static::createClient();
        $this->listingRepository = static::getContainer()->get(IListingRepository::class);
        $this->serializer = static::getContainer()->get(SerializerInterface::class);
    }

    public function testGetListings()
    {
        // Arrange
        $listing = $this->generateListing();

        $this->listingRepository->create($listing);

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
        $id = $this->listingRepository->create($listing);

        $found = $this->listingRepository->getById($id);
        $this->assertEquals($id, $found->getId());

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
        $id = $this->listingRepository->create($listing);

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
        $this->assertEquals($expected_new_title, $updated->getTitle());
        $this->assertResponseStatusCodeSame(200);
        $this->assertEquals($decoded['id'], $id);
    }

    public function testCreateListing()
    {
        // Arrange
        $user = new User();

        $user->setName('JohnDoe')
             ->setEmail('john@example.com')
             ->setDisplayName('John D.')
             ->setPhone('+123456789')
             ->setLocation('New York')
             ->setLanguage('en');

        $category = new Category();
        $category->setName('Electronics');

        $userRepository = static::getContainer()->get(IUserRepository::class);
        $categoryRepository = static::getContainer()->get(ICategoryRepository::class);

        $userId = $userRepository->create($user);
        $categoryId = $categoryRepository->create($category);

        // Act
        $dto = new CreateListingDTO();

        $dto->title = 'MyTitle';        // Must be 5-10 chars to satisfy validation
        $dto->price = 100;              // Must be >= 3
        $dto->description = 'A great listing description';
        $dto->categoryId = $categoryId;           // Example category ID
        $dto->authorId = $userId;            // Example author/user ID
        $dto->currency = 'USD';         // Must be 3-4 chars
        $dto->location = 'New York';
        $dto->status = 'active';

        $json = $this->serializer->serialize($dto, 'json');

        $old = $this->listingRepository->getAll();
        $this->assertEquals(0, count($old));

        $this->client->request(
            method: Request::METHOD_POST,
            uri: $this->path,
            content: $json,
            server: ['CONTENT_TYPE' => 'application/json']
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $decoded = json_decode($content, true);

        // Assert
        $new = $this->listingRepository->getAll();
        $this->assertEquals(1, count($new));
        $this->assertResponseStatusCodeSame(201);
        $this->assertEquals($decoded['id'], $new[0]->getId());
    }

    private function generateListing(): Listing
    {
        $user = UserFactory::create(
            name: $this->faker->name(),
            email: $this->faker->email(),
            displayName: $this->faker->name(),
            phone: $this->faker->phoneNumber(),
            location: $this->faker->address(),
            language: 'en',
        );

        $category = CategoryFactory::create('books');

        $listing = ListingFactory::create(
            title: $this->faker->jobTitle(),
            description: $this->faker->text(100),
            category: $category,
            price: 500,
            currency: 'eur',
            location: $this->faker->address(),
            status: 'published',
            author: $user
        );

        return $listing;
    }

    public function testGetListingByIdSuccess()
    {
        // Arrange
        $listing = $this->generateListing();

        $id = $this->listingRepository->create($listing);
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
