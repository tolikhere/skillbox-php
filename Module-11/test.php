
<?php

require_once __DIR__ . '/TelegraphText.php';

use Dpo\Php\Developer\Base\Module11\TelegraphText;

// Testing getters and setters TelegraphText


$telegraph = new TelegraphText('Tolik', 'Animals');

echo "A initial author is {$telegraph->author}" . PHP_EOL;
$telegraph->author = str_repeat('Donky', 25);
echo 'The author must not change-> ' . $telegraph->author . PHP_EOL;
$telegraph->author = 'Shrek';
echo 'The author must change-> ' . $telegraph->author . PHP_EOL;
echo PHP_EOL;

echo "A initial slug is {$telegraph->slug}" . PHP_EOL;
$telegraph->slug = 'N 1w_Animals';
echo 'The slug must not change-> ' . $telegraph->slug . PHP_EOL;
$telegraph->slug = 'New_Animals23';
echo 'The slug must change-> ' . $telegraph->slug . PHP_EOL;
echo PHP_EOL;

echo "A initial date is {$telegraph->published}" . PHP_EOL;
$telegraph->published = '01-01-2021';
echo 'The published date must not change' . $telegraph->published . PHP_EOL;
$telegraph->published = '01-01-2025';
echo 'The published date must change-> ' . $telegraph->published . PHP_EOL;
echo PHP_EOL;

$telegraph->editText('Animals', 'Dogs, cats, mice');
echo "A initial text is {$telegraph->text}" . PHP_EOL;
$telegraph->text = 'Eagles, Bears, Tigers';
echo "The changed text-> {$telegraph->text}" . PHP_EOL;
