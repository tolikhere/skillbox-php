<?php

spl_autoload_register(function ($class) {
    $className = preg_replace("/.*\\\\/", '', $class);
    $file = "./entities/{$className}.php";

    if (file_exists($file)) {
        require_once $file;
    }
});
