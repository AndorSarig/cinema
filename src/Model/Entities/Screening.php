<?php

namespace Model\Entities;


use Model\Interfaces\ObjectToArrayInterface;

class Screening implements ObjectToArrayInterface
{
    private $id;
    private $date;
    private $room;
    private $bookedSeatsIds;

    public function __construct(int $id, string $date, Room $room, string $bookedSeatsIds = null)
    {
        $this->id               = $id;
        $this->date             = date('Y F d D G:i', strtotime($date));
        $this->room             = $room;
        $this->bookedSeatsIds   = array_filter(explode(',', $bookedSeatsIds));
    }

    public function getId()
    {
        return $this->id;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function getRoom()
    {
        return $this->room;
    }

    public function getBookedSeatsIds()
    {
        return $this->bookedSeatsIds;
    }

    public function getFreeSeatsNumber()
    {
        return $this->room->getCapacity() - count($this->bookedSeatsIds);
    }

    public function getAsArray(): array
    {
        return [
            "id" => $this->id,
            "date" => $this->date
        ];
    }
}
