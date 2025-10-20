<?php

namespace App\Tests\DataFixtures;

use App\Domain\Category\CategoryFactory;
use App\Infrastructure\Doctrine\Entity\Category;
use App\Tests\Utils\FakerUtils;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    use FakerUtils;

    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $f = $this->getFaker();

        $category = CategoryFactory::create($f->company());

        $entity = Category::fromDomain($category);

        $manager->persist($entity);
        $manager->flush();
    }
}
