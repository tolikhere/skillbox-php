<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Homework\ArticleContentProviderInterface;
use App\Homework\ArticleProvider;
use App\Traits\ArticleContentGenerator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Faker\Factory;

class ArticlesController extends AbstractController
{
    use ArticleContentGenerator;

    #[Route('/admin/articles/create', name: 'app_admin_articles_create')]
    public function create(
        ArticleContentProviderInterface $articleContentProvider,
        ArticleProvider $articleProvider,
        EntityManagerInterface $entityManager
    ) {
        $faker = Factory::create();
        [
            'title' => $title,
            'slug' => $slug,
            'image' => $image
        ] = $articleProvider->article();

        $article = new Article();
        $body = $this->getArticleContent($articleContentProvider);
        $description = mb_substr($body, 0, 100);
        $article
            ->setTitle($title)
            ->setSlug($slug . '-' . mt_rand(1, 1000))
            ->setDescription($description)
            ->setBody($body)
            ->setAuthor($faker->name())
            ->setKeywords('programming, html, css, js, javascript, php, symfony')
            ->setVoteCount(mt_rand(-100, 100))
            ->setImageFilename($image)
            ->setPublishedAt(new \DateTimeImmutable($faker->date()))
        ;
        $entityManager->persist($article);
        $entityManager->flush();
        dd($article);
    }
}
