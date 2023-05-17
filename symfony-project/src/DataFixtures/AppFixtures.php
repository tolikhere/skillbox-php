<?php

namespace App\DataFixtures;

use App\Factory\ApiTokenFactory;
use App\Factory\ArticleFactory;
use App\Factory\CommentFactory;
use App\Factory\TagFactory;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Creating Many Users
        UserFactory::createMany(10, function () {
            return [
                'apiTokens' => ApiTokenFactory::new()->many(1),
            ];
        });
        // Creating Many Tags
        TagFactory::createMany(50);
        // Creating Many Articles
        ArticleFactory::createMany(25, function () {
            return [
                'comments' => CommentFactory::new()->many(2, 10),
                'tags' => TagFactory::randomRange(0, 5),
                'author' => UserFactory::random()
            ];
        });
        // Creating Admin
        UserFactory::createOne([
            'firstName' => 'Kratos',
            'email' => 'admin@symfony.skillbox',
            'isActive' => true,
            'roles' => ['ROLE_ADMIN'],
            'apiTokens' => ApiTokenFactory::new()->many(1),
        ]);
        // Creating API Admin
        UserFactory::createOne([
            'firstName' => 'Atreus',
            'email' => 'api@symfony.skillbox',
            'isActive' => true,
            'roles' => ['ROLE_API'],
            'apiTokens' => ApiTokenFactory::new()->many(3),
        ]);

        $manager->flush();
    }
}
