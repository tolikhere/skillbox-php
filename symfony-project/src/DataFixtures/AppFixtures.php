<?php

namespace App\DataFixtures;

use App\Factory\ArticleFactory;
use App\Factory\CommentFactory;
use App\Factory\TagFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        TagFactory::createMany(50);

        ArticleFactory::createMany(20, function () {
            return [
                'comments' => CommentFactory::new()->many(2, 10),
                'tags' => TagFactory::randomRange(0, 5),
            ];
        });
        $manager->flush();
    }
}
