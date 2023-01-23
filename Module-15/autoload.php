<?php

require_once './vendor/autoload.php';

spl_autoload_register(function ($class) {
    $className = preg_replace("/\\\\/", DIRECTORY_SEPARATOR, $class);
    $file = "./{$className}.php";

    if (file_exists($file)) {
        require_once $file;
    }
});
