<?php

namespace App\Traits;

trait ArticleContentGenerator
{
    private function getArticleContent(): string
    {
        // If number is less or equal to 70 then we'll send a random word and amount of it to the get method
        // If not then only amount of paragraphs
        $paragraphs = mt_rand(2, 10);
        $word = null;
        $wordsCount = 0;
        if (mt_rand(1, 10) <= 7) {
            $words = ['Is', 'Толик', 'Batman', 'Superman', 'or', 'Jedi'];
            $word = $words[mt_rand(0, count($words) - 1)];
            $wordsCount = mt_rand(1, 9);
        }

        return $this->articleContentProvider->get($paragraphs, $word, $wordsCount);
    }
}
