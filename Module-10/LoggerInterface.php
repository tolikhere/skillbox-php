<?php

namespace Dpo\Php\Developer\Base\Module10;

interface LoggerInterface
{
    public function logMessage(string $error): void;
    public function lastMessages(int $amount): array;
}
