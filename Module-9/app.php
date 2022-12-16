<?php

namespace Dpo\Php\Developer\Base\Module9\app;

require_once __DIR__ . '/TelegraphText.php';
require_once __DIR__ . '/FileStorage.php';

use Dpo\Php\Developer\Base\Module9\TelegraphText;
use Dpo\Php\Developer\Base\Module9\FileStorage;

$storage = new FileStorage();
$telegraph = new TelegraphText('Tolik', 'Animals', $storage);

$telegraph->editText('Animals', 'Dogs, cats, mice');
$telegraph->storeText();
//$storage->update($telegraph->slug, $telegraph);
print_r($telegraph->loadText());
print_r($storage->list());
//$storage->delete($telegraph->slug);
