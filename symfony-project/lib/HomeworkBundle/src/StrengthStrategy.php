<?php

namespace SymfonySkillbox\HomeworkBundle;

class StrengthStrategy extends Strategy
{
    protected function sort(array &$units): void
    {
        /**
         *  @param Unit $a
         *  @param Unit $b
         */
        \usort($units, function ($a, $b) {
            if ($a->getStrength() === $b->getStrength()) {
                return 0;
            }

            return ($a->getStrength() < $b->getStrength()) ? 1 : -1;
        });
    }
}
