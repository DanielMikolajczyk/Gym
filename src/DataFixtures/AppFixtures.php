<?php

namespace App\DataFixtures;

use App\Factory\CategoryFactory;
use App\Factory\ExcerciseFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $categories = CategoryFactory::createMany(5);

        $excercises = ExcerciseFactory::createMany(10);    


        $manager->flush();
    }
}
