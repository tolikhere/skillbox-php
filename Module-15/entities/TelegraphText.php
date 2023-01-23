<?php

namespace entities;

class TelegraphText
{
    private $title;
    private $text;
    private $author;
    private $published;
    private $slug;

    public function __construct(string $author, string $fileName)
    {
        $this->author = $author;
        $this->slug = $fileName;
        $this->published = date('d-m-Y');
    }

    public function setAuthor(string $author): void
    {
        if (mb_strlen($author) <= 120) {
            $this->author = $author;
        }
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function setSlug(string $slug): void
    {
        $isValidSlug = preg_match("/^[a-z0-9-_]{1,}$/i", $slug);

        if ($isValidSlug) {
            $this->slug = $slug;
        }
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setPublished($date): void //See DateTime class php.net for a valid input
    {
        //Use this format: day-month-Year => 01-01-2022(an example) for a input
        $oldDate = new \DateTime($this->published);
        $newDate = new \DateTime($date);

        if ($newDate >= $oldDate) {
            $this->published = $date;
        }
    }

    public function getPublished(): string
    {
        return $this->published;
    }

    private function storeText(): void
    {
        $store = [
            'author' => $this->author,
            'published' => $this->published,
            'title' => $this->title,
            'text' => $this->text,
        ];

        file_put_contents($this->slug, serialize($store));
    }

    private function loadText(): string
    {
        $file = $this->slug;
        if (file_exists($file) && filesize($file)) {
            $items = unserialize(file_get_contents($file));
            foreach ($items as $key => $value) {
                $this->$key  = $value;
            }
        }

        return $this->text;
    }

    public function editText(?string $title, string $text): void
    {
        $length = strlen($text);
        if ($length < 1 || $length > 500) {
            throw new \Exception('Длинна сообщения должна составлять от 1 до 500 символов');
        }
        $this->title = $title;
        $this->text = $text;
    }

    public function __set(string $name, $value)
    {
        switch ($name) {
            case 'author':
                $this->setAuthor($value);
                break;
            case 'slug':
                $this->setSlug($value);
                break;
            case 'published':
                $this->setPublished($value);
                break;
            case 'text':
                $this->editText($this->title, $value);
                $this->storeText();
                break;
        }
    }

    public function __get(string $name)
    {
        switch ($name) {
            case 'author':
                return $this->getAuthor();
            case 'slug':
                return $this->getSlug();
            case 'published':
                return $this->getPublished();
            case 'text':
                return $this->loadText();
        }
    }
}
