<?php

namespace App\Homework;

class ArticleWordsFilter
{
    public function filter(string $string, array $words = []): string
    {
        // if empty return unchanged $string
        if (empty($words)) {
            return $string;
        }

        $stringWords = explode(' ', $string);
        // comparing every word in $string with every word in $words
        $filteredWords = array_filter($stringWords, function ($stringWord) use ($words) {
            foreach ($words as $word) {
                if (mb_strpos($stringWord, $word) !== false) {
                    return false;
                }
            }

            return true;
        });
        return implode(' ', $filteredWords);
    }
}
