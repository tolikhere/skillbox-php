
<?php

require_once __DIR__ . '/autoload.php';

use Dpo\Php\Developer\Base\Module13\entities\FileStorage;

$storage = new FileStorage();

echo $storage::class . PHP_EOL;
