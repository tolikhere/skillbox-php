<?php

namespace Dpo\Php\Developer\Base\Module11;

interface LoggerInterface
{
    public function logMessage(string $error): void;
    public function lastMessages(int $amount): array;
}
