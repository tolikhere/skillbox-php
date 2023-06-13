<?php

namespace App\Homework;

use SymfonySkillbox\HomeworkBundle\Unit;
use SymfonySkillbox\HomeworkBundle\UnitProviderInterface;

class EnemyUnitProvider implements UnitProviderInterface
{
    /**
     * @return Unit[]
     */
    public function getUnits(): array
    {
        return [
            new Unit('Ork', 90, 4, 120, 2),
            new Unit('Armored Ork', 150, 7, 180, 3),
            new Unit('Troll', 250, 15, 250, 1),
        ];
    }
}
