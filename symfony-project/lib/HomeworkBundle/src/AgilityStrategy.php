<?php

namespace SymfonySkillbox\HomeworkBundle;

class AgilityStrategy extends Strategy
{
    protected function sort(array &$units): void
    {
        /**
         *  @param Unit $a
         *  @param Unit $b
         */
        \usort($units, function ($a, $b) {
            if ($a->getAgility() === $b->getAgility()) {
                return 0;
            }

            return ($a->getAgility() < $b->getAgility()) ? 1 : -1;
        });
    }
}
