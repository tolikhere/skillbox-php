<?php

namespace Dpo\Php\Developer\Base\Module13\interfaces;

interface EventListenerInterface
{
    public function attachEvent($method, $callBack): void;
    public function detouchEvent($method): void;
}
