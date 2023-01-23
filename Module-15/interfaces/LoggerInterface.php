<?php

namespace interfaces;

interface LoggerInterface
{
    public function logMessage(string $error): void;
    public function lastMessages(int $amount): array;
}
