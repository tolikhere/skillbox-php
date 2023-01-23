
<?php

require_once __DIR__ . '/autoload.php';

use entities\FileStorage;

$storage = new FileStorage();

echo $storage::class . PHP_EOL;
