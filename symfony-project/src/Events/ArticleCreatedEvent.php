<?php

namespace App\Events;

use App\Entity\Article;
use Symfony\Contracts\EventDispatcher\Event;

class ArticleCreatedEvent extends Event
{
    public function __construct(
        private Article $article
    ) {
    }

    public function getArticle(): Article
    {
        return $this->article;
    }
}
