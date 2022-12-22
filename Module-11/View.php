<?php

namespace Dpo\Php\Developer\Base\Module11;

abstract class View
{
    public $storage;

    public function __construct(object $obj)
    {
        $this->storage = $obj;
    }

    abstract public function displayTextById($id);
    abstract public function displayTextByUrl(string $url);
}
