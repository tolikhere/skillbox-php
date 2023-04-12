<?php

namespace App\Controller;

use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleVoteController extends AbstractController
{
    #[Route('/articles/{slug}/vote/up', name: 'app_article_vote_up', methods: ['POST'])]
    public function voteUp(Article $article, EntityManagerInterface $entityManager): Response
    {
        $article->voteUp();
        $entityManager->flush();
        return $this->json(['votes' => $article->getVoteCount()]);
    }

    #[Route('/articles/{slug}/vote/down', name: 'app_article_vote_down', methods: ['POST'])]
    public function voteDown(Article $article, EntityManagerInterface $entityManager): Response
    {
        $article->voteDown();
        $entityManager->flush();
        return $this->json(['votes' => $article->getVoteCount()]);
    }
}
