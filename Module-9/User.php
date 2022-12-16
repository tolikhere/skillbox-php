<?php

namespace Dpo\Php\Developer\Base\Module9;

abstract class User
{
    public $id;
    public $name;
    public $role;

    abstract public function getTextsToEdit();
}
