<?php

namespace App\Homework;

use SymfonySkillbox\HomeworkBundle\Strategy;
use SymfonySkillbox\HomeworkBundle\Unit;

class BillGatesStrategy extends Strategy
{
    protected function sort(array &$units): void
    {
        \usort($units, function (Unit $a, Unit $b) {
            if ($a->getCost() === $b->getCost()) {
                return 0;
            }

            return ($a->getCost() < $b->getCost()) ? 1 : -1;
        });
    }
}
