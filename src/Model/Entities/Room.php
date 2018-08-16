<?php

namespace Model\Entities;

use Model\Interfaces\ObjectToArrayInterface;

class Room implements ObjectToArrayInterface
{
    private $id;
    private $nameText;
    private $capacity;

    public function __construct(int $id, string $name, int $capacity)
    {
        $this->id = $id;
        $this->nameText = $name;
        $this->capacity = $capacity;
    }

    public function getNameText(): string
    {
        return $this->nameText;
    }

    public function getCapacity(): int
    {
        return $this->capacity;
    }

    public function getAsArray(): array
    {
        return [
            "id" => $this->id,
            "name" => $this->nameText,
            "capacity" => $this->capacity
        ];
    }
}