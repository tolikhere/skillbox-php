<?php

namespace interfaces;

interface EventListenerInterface
{
    public function attachEvent($method, $callBack): void;
    public function detouchEvent($method): void;
}
