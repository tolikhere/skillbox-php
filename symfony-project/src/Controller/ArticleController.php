<?php

namespace App\Controller;

use App\Homework\ArticleContentProvider;
use App\Homework\ArticleContentProviderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    public function showDetail(ArticleProvider $articleProvider, ArticleContentProvider $content): Response
    {
        // If number is less or equal to 70 then we'll send a random word and amount of it to the get method
        // If not then only amount of paragraphs
        $paragraphs = mt_rand(2, 10);
        $word = null;
        $wordsCount = 0;
        if (mt_rand(1, 100) <= 70) {
            $words = ['Is', 'Толик', 'Batman', 'Superman', 'or', 'Jedi'];
            $word = $words[mt_rand(0, count($words) - 1)];
            $wordsCount = mt_rand(1, 9);
        }
        $articleContent = $content->get($paragraphs, $word, $wordsCount);

        return $this->render('articles/detail.html.twig', [
            'article' => $articleProvider->article(),
            'content' => $articleContent
        ]);
    }

    #[Route('/articles/article-content', name: 'app_article_content', methods: ['GET'])]
    public function generateArticle(Request $request, ArticleContentProviderInterface $articleContentProvider): Response
    {
        $paragraphs = is_numeric($request->query->get('paragraphs')) ? (int) $request->query->get('paragraphs') : 0;
        $word = $request->query->get('word') ?? null;
        $wordsCount = is_numeric($request->query->get('wordsCount')) ? (int) $request->query->get('wordsCount') : 0;

        return $this->render('articles/content.html.twig', [
            'content' => $articleContentProvider->get($paragraphs, $word, $wordsCount)
        ]);
    }
}
