<?php

namespace Dpo\Php\Developer\Base\Module10;

interface EventListenerInterface
{
    public function attachEvent($event): void;
    public function detouchEvent($event): void;
}
