<?php

namespace entities;

require_once __DIR__ . '/Storage.php';

class FileStorage extends Storage
{
    public function create(object $obj): mixed
    {
        $fileName = $obj->slug . date('_Y-m-d');
        $copiedName = $fileName;
        $end = 1;
        while (file_exists($fileName)) {
            $fileName = "{$copiedName}_{$end}";
            $end++;
        }
        $obj->slug = $fileName;
        file_put_contents($fileName, serialize($obj));

        return $obj->slug;
    }

    public function read(mixed $slug): object
    {
        if (is_string($slug)) {
            return unserialize(file_get_contents($slug));
        }
    }

    public function update(mixed $slug, object $obj): void
    {
        $serializedObj = serialize($obj);
        if (is_string($slug)) {
            file_put_contents($slug, $serializedObj);
        }
    }

    public function delete(mixed $slug): void
    {
        if (is_string($slug)) {
            unlink($slug);
        }
    }

    public function list(): array
    {
        $list = array_filter(scandir(__DIR__), 'is_file');
        $allowedClasses = ['allowed_classes' => ['TelegraphText']];
        return array_filter($list, fn ($file) => @unserialize(file_get_contents($file), $allowedClasses));
    }
}
