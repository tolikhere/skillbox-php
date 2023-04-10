<?php

namespace App\Homework;

use App\Homework\ArticleContentProviderInterface;

class ArticleContentProvider implements ArticleContentProviderInterface
{
    /**
     * You can change style in file .env MARK_ARTICLE_WORDS_WITH_BOLD parameter
     */
    public function __construct(private bool $isStyleBold)
    {
    }

    /**
     * Generate some random text with markdown syntax
     * And if $word and $wordsCount are given
     * Then there will be that $word in different places
     *
     * @return string
     */
    public function get(int $paragraphs, string $word = null, int $wordsCount = 0): string
    {
        $generatedParagraphs = $this->generateText($paragraphs);
        if ($word && $wordsCount) {
            $generatedParagraphs = $this->insertWord($generatedParagraphs, $word, $wordsCount);
        }
        return $generatedParagraphs;
    }

    /**
     * Generate some random text with markdown syntax from array of paragraphs
     * The amount of paragraphs depends on $amount
     *
     * @return string
     */
    private function generateText(int $amount): string
    {
        $paragraphs = [
            '> "Courage wasn\'t a matter of taking the whole mountain in a single massive
leap. Courage was taking it one step at a time, doing what was necessary now,
preparing for the next step, and refusing to worry about whether some step in
the future would be the one that would break him" - *Kell Tainer*.'
            ,
            '> "Anger always makes you feel good at the time. Makes you feel bigger than
yourself, and makes you feel that everything you do is justified. But it\'s a trap" - *Corran Horn*.'
            ,
            '> "To die for one\'s people is a great sacrifice. To live for one\'s people, an even
greater sacrifice. I choose to live for my people."  - *Riyo Chuchi*'
            ,
            '> "If you define yourself by your power to take life, your desire to dominate, to
possess, then you have nothing." - *Obi-Wan Kenobi*'
            ,
            '> "Always more questions than answers, there are." - *Yoda*'
            ,
        ];

        $length = count($paragraphs) - 1;
        $randomParagraphs = [];
        while ($amount > 0) {
            $randomParagraphs[] = $paragraphs[mt_rand(0, $length)];
            $amount--;
        }
                        // separate with "\n\n" for markdown syntax
        return implode("\n\n", $randomParagraphs);
    }

    /**
     * Insert a given word into random places between words
     * The amount of insertions depend on $wordsCount parameter
     * If there no spaces then return a given text
     * If $this->isStyleBold=true then $word will be bold if not then cursive
     *
     * @return string
     */
    private function insertWord(string $paragraphs, string $word, int $wordsCount): string
    {
        $words = explode(' ', $paragraphs);
        $formattedWord = $this->isStyleBold ? "**{$word}**" : "*{$word}*";
        while ($wordsCount > 0) {
            $length = count($words);
            $randomIndex = mt_rand(0, $length);
            array_splice($words, $randomIndex, 0, [$formattedWord]);
            $wordsCount--;
        }

        return implode(' ', $words);
    }
}
