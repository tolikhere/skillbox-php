<?php

namespace App\Homework;

use App\Homework\PasteWords;

class CommentContentProvider implements CommentContentProviderInterface
{
    public function __construct(private PasteWords $pasteWords)
    {
    }

    public function get(string $word = null, int $wordsCount = 0): string
    {
        $paragraphs = \Faker\Factory::create()->paragraph(mt_rand(1, 3));
        $comment = $this->pasteWords->paste($paragraphs, $word, $wordsCount);
        return $comment;
    }
}
