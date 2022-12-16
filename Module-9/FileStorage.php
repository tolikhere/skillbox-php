<?php

namespace Dpo\Php\Developer\Base\Module9;

require_once __DIR__ . '/Storage.php';


use Dpo\Php\Developer\Base\Module9\Storage;

class FileStorage extends Storage
{
    public function create(object $obj): mixed
    {
        $fileName = $obj->slug . date('_d-m-Y');
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

    public function read(mixed $idOrSlug): object
    {
        if (is_string($idOrSlug)) {
            return unserialize(file_get_contents($idOrSlug));
        }
    }

    public function update(mixed $idOrSlug, object $obj): void
    {
        $serializedObj = serialize($obj);
        if (is_string($idOrSlug)) {
            file_put_contents($idOrSlug, $serializedObj);
        }
    }

    public function delete(mixed $idOrSlug): void
    {
        if (is_string($idOrSlug)) {
            unlink($idOrSlug);
        }
    }

    public function list(): array
    {
        $list = array_filter(scandir(__DIR__), 'is_file');
        $allowedClasses = ['allowed_classes' => ['TelegraphText']];
        return array_filter($list, fn ($file) => @unserialize(file_get_contents($file), $allowedClasses));
    }
}
