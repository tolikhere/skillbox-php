<?php

namespace SymfonySkillbox\HomeworkBundle;

abstract class Strategy implements StrategyInterface
{
    private $sortedUnits;

    public function next(array $units, int $resource): ?Unit
    {
        if ($this->sortedUnits === null) {
            $this->sort($units);
            $this->sortedUnits = $units;
        }

        foreach ($this->sortedUnits as $unit) {
            if ($unit->getCost() <= $resource) {
                return $unit;
            }
        }

        return null;
    }

    abstract protected function sort(array &$units): void;
}
