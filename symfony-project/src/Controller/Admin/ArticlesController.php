<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class ArticlesController extends AbstractController
{
    #[Route(path: '/admin/articles/create', name: 'app_admin_articles_create')]
    public function create(): Response
    {
        return new Response('This is a Create Article Page.');
    }

    #[IsGranted('ARTICLE_EDIT', subject: 'article')]
    #[Route(path: '/admin/articles/{id}/edit', name: 'app_admin_articles_edit')]
    public function edit(Article $article): Response
    {
        return new Response('This is a Edit Article Page. ' . $article->getTitle());
    }
}
