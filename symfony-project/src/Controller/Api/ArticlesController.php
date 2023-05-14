<?php

namespace App\Controller\Api;

use App\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class ArticlesController extends AbstractController
{
    #[IsGranted('ARTICLE_VIEW', subject: 'article')]
    #[Route('/api/v1/articles/{id}', name: 'api_article_view_content', methods: ['GET'])]
    public function view(Article $article): JsonResponse
    {
        return $this->json($article, context: ['groups' => ['main']]);
    }
}
