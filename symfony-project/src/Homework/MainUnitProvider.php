<?php

namespace App\Homework;

use SymfonySkillbox\HomeworkBundle\Unit;
use SymfonySkillbox\HomeworkBundle\UnitProviderInterface;

class MainUnitProvider implements UnitProviderInterface
{
    /**
     * @return Unit[]
     */
    public function getUnits(): array
    {
        return [
            new Unit('Knight', 180, 7, 200, 4),
            new Unit('Berserk', 190, 10, 160, 3),
            new Unit('Assassin', 210, 5, 120, 15),
        ];
    }
}
