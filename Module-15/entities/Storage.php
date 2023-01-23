<?php

namespace entities;

require_once __DIR__ . '/../interfaces/LoggerInterface.php';
require_once __DIR__ . '/../interfaces/EventListenerInterface.php';

use interfaces\LoggerInterface;
use interfaces\EventListenerInterface;

abstract class Storage implements LoggerInterface, EventListenerInterface
{
    public const ERROR_DIR = __DIR__ . '/../errors.log';

    abstract public function create(object $obj): mixed;
    abstract public function read(mixed $slug): object;
    abstract public function update(mixed $slug, object $obj): void;
    abstract public function delete(mixed $slug): void;
    abstract public function list(): array;

    public function logMessage(string $msg): void
    {
        if (file_exists(self::ERROR_DIR) && filesize(self::ERROR_DIR)) {
            $messages = unserialize(file_get_contents(self::ERROR_DIR));
            $messages[] = $msg;

            file_put_contents(self::ERROR_DIR, serialize($messages));
        } else {
            $messages = [$msg];

            file_put_contents(self::ERROR_DIR, serialize($messages));
        }
    }

    public function lastMessages(int $amount): array
    {
        if (file_exists(self::ERROR_DIR) && filesize(self::ERROR_DIR) && $amount > 0) {
            $messages = unserialize(file_get_contents(self::ERROR_DIR));

            return array_slice($messages, -$amount);
        }

        return [];
    }

    public function attachEvent($method, $callBack): void
    {
    }

    public function detouchEvent($method): void
    {
    }
}
