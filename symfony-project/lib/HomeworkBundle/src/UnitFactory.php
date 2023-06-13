<?php

namespace SymfonySkillbox\HomeworkBundle;

class UnitFactory
{
    private $unitList;

    /**
     * @param StrategyInterface $strategy
     * @param UnitProviderInterface[] $unitProviders
     */
    public function __construct(
        private StrategyInterface $strategy,
        private iterable $unitProviders
    ) {
    }

    /**
     * Creating an army
     * @param int $resources
     * @return Unit[]
     */
    public function produceUnits(int $resources): array
    {
        $units = $this->getUnits();

        $army = [];
        while ($unit = $this->strategy->next($units, $resources)) {
            $army[] = $unit;
            $resources -= $unit->getCost();
        }

        return $army;
    }

    /**
     * Creating the list of available units
     * @return Unit[]
     */
    private function getUnits(): array
    {
        if (null === $this->unitList) {
            $units = [];
            foreach ($this->unitProviders as $unitProvider) {
                $units = \array_merge($units, $unitProvider->getUnits());
            }

            $this->unitList = $units;
        }

        return $this->unitList;
    }
}
