<?php

namespace App\Form\DataTransformer;

use App\Homework\ArticleWordsFilter;
use Symfony\Component\Form\DataTransformerInterface;

class ArticleWordsFilterTransformer implements DataTransformerInterface
{
    private array $stopWords = [
        'стакан', 'лебедь', 'рак', 'щука'
    ];

    public function __construct(
        private ArticleWordsFilter $articleWordsFilter
    ) {
    }
    public function transform($string): string
    {
        if ($string === null) {
            return '';
        }

        return $string;
    }

    public function reverseTransform($string): string
    {
        if (! $string) {
            return '';
        }

        return $this->articleWordsFilter->filter($string, $this->stopWords);
    }
}
