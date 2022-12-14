<?php

namespace Dpo\Php\Developer\Base\Module8;

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
        $this->published = date('H:i:s F jS, Y');
    }

    public function storeText(): void
    {
        $store = [
            'author' => $this->author,
            'published' => $this->published,
            'title' => $this->title,
            'text' => $this->text,
        ];

        file_put_contents($this->slug, serialize($store));
    }

    public function loadText(): string
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

    public function editText(string $title, string $text): void
    {
        $this->title = $title;
        $this->text = $text;
    }
}

$title = 'Upcoming Games';
$text = <<<EOT
1) Suicide Squad Kill the Justice League
2) Diablo IV
3) Atomic Heart
4) Cyberpunk 2077 Liberty City
5) Street Fighter 6
6) Tekken 8
7) Death Stranding 2
8) Dragon Age: Dreadwolf
9) The Elder Scrolls VI
EOT;

$telegraph = new TelegraphText('Tolik', 'Future_Games.txt');

$telegraph->editText($title, $text);
$telegraph->storeText();
echo $telegraph->loadText() . PHP_EOL;
//print_r($telegraph);
