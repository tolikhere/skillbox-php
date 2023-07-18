<?php

namespace App;

/**
 * @property-read ?array $db
 */
class Config
{
    protected array $config = [];

    public function __construct(array $env)
    {
        // I didn't implement $env data so put your data into default one
        // they after double question mark
        $this->config = [
            'db' => [
                'host'     => $env['DB_HOST']     ?? 'cloud-storage-db',
                'user'     => $env['DB_USER']     ?? 'root',
                'pass'     => $env['DB_PASS']     ?? 'root',
                'database' => $env['DB_DATABASE'] ?? 'cloud_storage',
                'driver'   => $env['DB_DRIVER']   ?? 'mysql',
            ],
        ];
    }

    public function __get(string $name)
    {
        return $this->config[$name] ?? null;
    }
}
