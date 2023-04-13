<?php

namespace App\DataFixtures;

use App\Factory\ArticleFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        ArticleFactory::createMany(15);

        $manager->flush();
    }
}
