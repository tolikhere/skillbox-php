<?php

namespace App\Controller\Api;

use App\Entity\User;
use App\Homework\ArticleContentProviderInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ArticleContentProviderController extends AbstractController
{
    #[Route('/api/v1/article_content', name: 'api_article_content_provider', methods: ['POST'])]
    public function index(
        Request $request,
        ArticleContentProviderInterface $articleContentProvider,
        LoggerInterface $apiLogger
    ): JsonResponse {
        /** @var User $user */
        $user = $this->getUser();
        if (! $this->isGranted('ROLE_API')) {
            $apiLogger->warning('User {userName} has tried to access /api/v1/article_content', [
                'userName' => $user?->getFirstName() ?? null,
                'roles' => $user?->getRoles() ?? null,
                'isAuthorized' => (bool) $user,
            ]);
            return $this->json(['message' => 'You Shall Not Pass!'], 401);
        }
        $data = $request->toArray();
        $paragraphs = $data['paragraphs'] ?? 0;
        $word = $data['word'] ?? null;
        $wordsCount = $data['wordsCount'] ?? 0;

        return $this->json([
            'text' => $articleContentProvider->get($paragraphs, $word, $wordsCount)
        ]);
    }
}
