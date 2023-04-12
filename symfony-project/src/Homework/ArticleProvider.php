<?php

namespace App\Homework;

class ArticleProvider
{
    /**
     * @staticvar array
     */
    private static $articles = [
        [
            'title' => 'Что делать, если надо верстать?',
            'slug'  => 'what-to-do-if-you-need-to-type',
            'image' => 'article-2.jpeg',
        ],
        [
            'title' => 'Facebook ест твои данные',
            'slug'  => 'facebook-eats-your-data',
            'image' => 'article-1.jpeg',
        ],
        [
            'title' => 'Когда пролил кофе на клавиатуру',
            'slug'  => 'when-spilled-coffee-on-keyboard',
            'image' => 'article-3.jpg',
        ]
    ];

    /**
     * Return all articles
     *
     * @return array
     */

    public function articles(): array
    {
        return self::$articles;
    }

    /**
     * Generates random article
     *
     * @return array
     */
    public function article(): array
    {
        return self::articles()[array_rand(self::articles())];
    }
}
