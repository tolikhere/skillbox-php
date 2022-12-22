<?php

namespace Dpo\Php\Developer\Base\Module11;

require_once __DIR__ . '/EventListenerInterface.php';

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
