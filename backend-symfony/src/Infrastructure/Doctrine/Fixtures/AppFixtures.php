<?php

namespace App\Infrastructure\Doctrine\Fixtures;

use App\Infrastructure\Doctrine\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $category = new Category()->setName('books');
        $manager->persist($category);
        $manager->flush();
    }
}
