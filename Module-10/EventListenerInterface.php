<?php

namespace Dpo\Php\Developer\Base\Module10;

interface EventListenerInterface
{
    public function attachEvent($method, $callBack): void;
    public function detouchEvent($method): void;
}
