<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Homework\ArticleProvider;

class ArticleController extends AbstractController
{
    #[Route('/', name: 'app_homepage', methods: ['GET'])]
    public function homepage(ArticleProvider $articleProvider): Response
    {
        return $this->render('articles/homepage.html.twig', [
            'title' => 'Spill-Coffee-On-The-Keyboard',
            'articles' => $articleProvider->articles(),
        ]);
    }

    #[Route('/detail', name: 'app_article_detail', methods: ['GET'])]
    public function showDetail(ArticleProvider $articleProvider): Response
    {
        return $this->render('articles/detail.html.twig', [
            'article' => $articleProvider->article(),
        ]);
    }
}
