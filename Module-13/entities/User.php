<?php

namespace Dpo\Php\Developer\Base\Module13\entities;

require_once __DIR__ . '/../interfaces/EventListenerInterface.php';

use Dpo\Php\Developer\Base\Module13\interfaces\EventListenerInterface;

abstract class User implements EventListenerInterface
{
    protected $id;
    protected $name;
    protected $role;

    abstract public function getTextsToEdit();

    public function attachEvent($method, $callBack): void
    {
    }
    public function detouchEvent($method): void
    {
    }
}
