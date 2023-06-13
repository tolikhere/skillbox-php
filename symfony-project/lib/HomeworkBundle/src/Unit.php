<?php

namespace SymfonySkillbox\HomeworkBundle;

class Unit
{
    public function __construct(
        private string $name,
        private int $cost,
        private int $strength,
        private int $health,
        private int $agility
    ) {
    }

    /**
     * Get the value of name
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get the value of cost
     * @return int
     */
    public function getCost(): int
    {
        return $this->cost;
    }

    /**
     * Get the value of strength
     * @return int
     */
    public function getStrength(): int
    {
        return $this->strength;
    }

    /**
     * Get the value of health
     * @return int
     */
    public function getHealth(): int
    {
        return $this->health;
    }

    /**
     * Get the value of agility
     * @return int
     */
    public function getAgility(): int
    {
        return $this->agility;
    }
}
