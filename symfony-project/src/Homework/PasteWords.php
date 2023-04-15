<?php

namespace App\Homework;

class PasteWords
{
    public function paste(string $text, string $word, int $wordsCount = 1): string
    {
        if ($wordsCount <= 0) {
            return $text;
        }
        $words = explode(' ', $text);

        while ($wordsCount > 0) {
            $length = count($words);
            $randomIndex = mt_rand(0, $length);
            array_splice($words, $randomIndex, 0, [$word]);
            $wordsCount--;
        }

        return implode(' ', $words);
    }
}
