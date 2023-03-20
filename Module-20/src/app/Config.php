<?php

namespace App;

enum Config
{
    case DRIVER;
    case HOST;
    case USER;
    case PASS;
    case DATABASE;

    public function toString()
    {
        return match ($this) {
            Config::DRIVER   => $_ENV['DB_DRIVER'] ?? 'mysql',
            Config::HOST     => $_ENV['DB_HOST'],
            Config::USER     => $_ENV['DB_USER'],
            Config::PASS     => $_ENV['DB_PASS'],
            Config::DATABASE => $_ENV['DB_DATABASE']
        };
    }
}
