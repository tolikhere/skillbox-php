<?php

namespace App\Controller;

use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleVoteController extends AbstractController
{
    #[Route(
        '/articles/{slug}/vote/{direction}',
        name: 'app_article_vote',
        requirements: ['direction ' => 'up|down'],
        methods: ['POST']
    )]
    public function vote(Article $article, string $direction, EntityManagerInterface $entityManager): Response
    {
        if ($direction === 'up') {
            $article->voteUp();
        } else {
            $article->voteDown();
        }
        $entityManager->flush();
        return $this->json(['votes' => $article->getVoteCount()]);
    }
}
