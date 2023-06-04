<?php

namespace App\Controller;

use App\Homework\ArticleContentProviderInterface;
use App\Traits\ArticleContentGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ArticleRepository;

class ArticleController extends AbstractController
{
    use ArticleContentGenerator;

    #[Route('/', name: 'app_homepage', methods: ['GET'])]
    public function homepage(ArticleRepository $articleRepository): Response
    {
        $articles = $articleRepository->orderByPublishedAtField();

        return $this->render('articles/homepage.html.twig', [
            'title' => 'Spill-Coffee-On-The-Keyboard',
            'articles' => $articles,
        ]);
    }

    #[Route('/detail/{slug}', name: 'app_article_detail', methods: ['GET'])]
    public function showDetail(string $slug = null, ArticleRepository $articleRepository): Response
    {
        $article = $articleRepository->findBySlugField($slug);
        return $this->render('articles/detail.html.twig', [
            'article' => $article[0]
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
