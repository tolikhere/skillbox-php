
<?php

require_once __DIR__ . '/TelegraphText.php';
//require_once __DIR__ . '/FileStorage.php';

use Dpo\Php\Developer\Base\Module11\TelegraphText;
//use Dpo\Php\Developer\Base\Module11\FileStorage;

function showData($obj, $fields)
{
    foreach ($fields as $i => $field) {
        $i++;
        echo "{$i}) {$field}: {$obj->$field}" . PHP_EOL;
    }
}

$fields = ['author', 'published', 'slug', 'text'];
$telegraph = new TelegraphText('Tolik', 'Animals');
$telegraph->editText('Animals', 'Dogs, cats, mice');
echo 'Old Data:' . PHP_EOL;
showData($telegraph, $fields);

echo PHP_EOL;

$telegraph->slug = 'New_Animals23';
//$telegraph->slug = 'N 1w_Animals';
$telegraph->author = 'Shrek';
//$telegraph->author = str_repeat('Donky', 25);
$telegraph->published = '2025-02-01';
//$telegraph->published = '2022-01-15';
$telegraph->editText('One for all', 'Eagles, Bears, Tigers');
echo 'New Data:' . PHP_EOL;
showData($telegraph, $fields);
