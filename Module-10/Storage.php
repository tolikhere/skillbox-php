<?php

namespace Dpo\Php\Developer\Base\Module10;

require_once __DIR__ . '/LoggerInterface.php';
require_once __DIR__ . '/EventListenerInterface.php';

abstract class Storage implements LoggerInterface, EventListenerInterface
{
    abstract public function create(object $obj): mixed;
    abstract public function read(mixed $idOrSlug): object;
    abstract public function update(mixed $idOrSlug, object $obj): void;
    abstract public function delete(mixed $idOrSlug): void;
    abstract public function list(): array;
}
