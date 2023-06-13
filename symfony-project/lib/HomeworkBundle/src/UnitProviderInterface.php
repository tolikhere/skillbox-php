<?php

namespace SymfonySkillbox\HomeworkBundle;

interface UnitProviderInterface
{
    /**
     * Returning array of units that can be used in UnitFactory
     * to produce an army from them
     * @return Unit[]
     */
    public function getUnits(): array;
}
