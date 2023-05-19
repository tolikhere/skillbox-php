<?php

namespace App\Homework;

class RegistrationSpamFilter
{
    public function filter(string $email): bool
    {
        $parts = explode('.', $email);

        return ! in_array($parts[count($parts) - 1], ['ru', 'com', 'org']);
    }
}
