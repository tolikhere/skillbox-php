<?php

namespace Dpo\Php\Developer\Base\Module9;

class TelegraphText
{
    private $title;
    private $text;
    private $author;
    private $published;
    public $slug;
    private $storage;

    public function __construct(string $author, string $fileName, object $storage)
    {
        $this->author = $author;
        $this->slug = $fileName;
        $this->published = date('H:i:s F jS, Y');
        $this->storage = $storage;
    }

    public function storeText(): void
    {
        $store = [
            'author' => $this->author,
            'published' => $this->published,
            'title' => $this->title,
            'text' => $this->text,
        ];

        //file_put_contents($this->slug, serialize($store));
        $this->storage->create($this);
    }

    public function loadText(): mixed
    {
        $file = $this->slug;
        if (file_exists($file) && filesize($file)) {
            $items = unserialize(file_get_contents($file));
            foreach ($items as $key => $value) {
                $this->$key  = $value;
            }
        }

//        return $this->text;
        return $this->storage->read($this->slug);
    }

    public function editText(string $title, string $text): void
    {
        $this->title = $title;
        $this->text = $text;
    }
}
