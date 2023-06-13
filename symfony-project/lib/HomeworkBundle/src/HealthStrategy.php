<?php

namespace SymfonySkillbox\HomeworkBundle;

class HealthStrategy extends Strategy
{
    protected function sort(array &$units): void
    {
        /**
         *  @param Unit $a
         *  @param Unit $b
         */
        \usort($units, function ($a, $b) {
            if ($a->getHealth() === $b->getHealth()) {
                return 0;
            }

            return ($a->getHealth() < $b->getHealth()) ? 1 : -1;
        });
    }
}
