<?php

namespace App\Controller\Api;

use App\Homework\ArticleContentProviderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleContentProviderController extends AbstractController
{
    #[Route('/api/v1/article-content/', name: 'api_article_content', methods: ['POST'])]
    public function index(Request $request, ArticleContentProviderInterface $articleContentProvider): JsonResponse
    {
        $data = $request->toArray();
        $paragraphs = $data['paragraphs'] ?? 0;
        $word = $data['word'] ?? null;
        $wordsCount = $data['wordsCount'] ?? 0;

        return $this->json([
            'text' => $articleContentProvider->get($paragraphs, $word, $wordsCount)
        ]);
    }
}
