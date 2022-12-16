<?php

namespace Dpo\Php\Developer\Base\Module9;

abstract class Storage
{
    abstract public function create(object $obj): mixed;
    abstract public function read(mixed $idOrSlug): object;
    abstract public function update(mixed $idOrSlug, object $obj): void;
    abstract public function delete(mixed $idOrSlug): void;
    abstract public function list(): array;
}
