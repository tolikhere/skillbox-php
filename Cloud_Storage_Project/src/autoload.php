<?php

/**
 * @param string $class The fully-qualified class
 * @return void
 */

spl_autoload_register(function (string $class) {
    // project-specific namespace prefix
    $prefix = 'App\\';

    // base directory for the namespace prefix
    $baseDir = __DIR__ . '/app/';

    // does the class use the namespace prefix?
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len)) {
        // no, move to the next registered autoloader
        return;
    }

    // get the relative class name
    $relativeClass = substr($class, $len);

    // replace the namespace prefix with the base directory, replace namespace
    // separators with directory separators in the relative class name, append
    // with .php
    $file = $baseDir . str_replace('\\', DIRECTORY_SEPARATOR, $relativeClass) . '.php';
    // if the file exists, require it
    if (file_exists($file)) {
        require $file;
    }
});
