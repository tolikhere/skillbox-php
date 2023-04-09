<?php

namespace App\Controller;

use App\Homework\ArticleContentProvider;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Homework\ArticleProvider;
use Symfony\Component\HttpFoundation\Request;

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
    public function showDetail(ArticleProvider $articleProvider, ArticleContentProvider $content): Response
    {
        // If number is less or equal to 70 then we'll send a random word and amount of it to the get method
        // If not then only amount of paragraphs
        $paragraphsCount = mt_rand(2, 10);
        if (mt_rand(1, 100) <= 70) {
            $words = ['Is', 'Толик', 'Batman', 'Superman', 'or', 'Jedi'];
            $randomWord = $words[mt_rand(0, count($words) - 1)];
            $wordsCount = mt_rand(1, 9);

            $articleContent = $content->get(
                $paragraphsCount,
                $randomWord,
                $wordsCount
            );
        } else {
            $articleContent = $content->get($paragraphsCount);
        }

        return $this->render('articles/detail.html.twig', [
            'article' => $articleProvider->article(),
            'content' => $articleContent
        ]);
    }

    #[Route('/api/v1/article-content/', name: 'api_article_content', methods: ['POST'])]
    public function sendArticle(Request $request, ArticleContentProvider $content): Response
    {
        $paragraphs = $request->request->get('paragraphs');
        $word = $request->request->get('word');
        $wordsCount = $request->request->get('wordsCount');

        return $this->json([
            'text' => $content->get($paragraphs, $word, $wordsCount ?? 0)
        ]);
    }
}
