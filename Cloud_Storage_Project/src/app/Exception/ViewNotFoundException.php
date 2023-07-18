<?php

namespace App\Exception;

class ViewNotFoundException extends \Exception
{
    protected $message = 'View not found';
}
