<?php

namespace Dpo\Php\Developer\Base\Module10;

require_once __DIR__ . '/EventListenerInterface.php';

abstract class User implements EventListenerInterface
{
    public $id;
    public $name;
    public $role;

    abstract public function getTextsToEdit();
}
