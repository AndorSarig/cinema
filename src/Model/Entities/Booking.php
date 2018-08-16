<?php

namespace Model\Entities;


use Model\Interfaces\ObjectToArrayInterface;

class Booking implements ObjectToArrayInterface
{
    private $id;
    private $screening;
    private $reservedPlace;

    public function __construct(int $id, Screening $screening, int $reservedPlace)
    {
        $this->id               = $id;
        $this->screening        = $screening;
        $this->reservedPlace    = $reservedPlace;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getScreening(): Screening
    {
        return $this->screening;
    }

    public function getReservedPlace(): int
    {
        return $this->reservedPlace;
    }

    public function getAsArray(): array
    {
        // TODO: Implement getAsArray() method.
    }
}