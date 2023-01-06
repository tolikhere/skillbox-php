<?php

namespace Dpo\Php\Developer\Base\Module13\interfaces;

interface LoggerInterface
{
    public function logMessage(string $error): void;
    public function lastMessages(int $amount): array;
}
