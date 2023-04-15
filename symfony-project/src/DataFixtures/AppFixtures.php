<?php

namespace App\DataFixtures;

use App\Factory\ArticleFactory;
use App\Factory\CommentFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        ArticleFactory::createMany(20, function () {
            return [
                'comments' => CommentFactory::new()->many(2, 10),
            ];
        });
        $manager->flush();
    }
}
