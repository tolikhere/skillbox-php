<?php

$searchRoot = 'test_search';
$searchName = 'test.txt';
$searchResult = [];

function findFiles(string $initialDir, string $searchFile, array &$searchResult): void
{
    $currFiles = @scandir($initialDir);
    if ($currFiles) {
        for ($i = 2, $len = count($currFiles); $i < $len; $i += 1) {
            $file = $currFiles[$i];
            $fileRoot = "{$initialDir}/{$file}";
            if (is_dir($fileRoot)) {
                findFiles($fileRoot, $searchFile, $searchResult);
            } else {
                $searchFile === $file && $searchResult[] = $fileRoot;
            }
        }
    } else {
        print_r('There is not shuch a directory! I wish you would quit bothering me.' . PHP_EOL);
    }
}

function showFoundResult(array $items): void
{
    $result = empty($items) ? 'There is not shuch a file' : $items;
    print_r($result);
    echo PHP_EOL;
}

$isFileNotEmpty = fn (string $file) => (bool) filesize($file);

findFiles($searchRoot, $searchName, $searchResult);
showFoundResult($searchResult);

$filteredResult = array_filter($searchResult, $isFileNotEmpty);
showFoundResult($filteredResult);
