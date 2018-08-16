<?php

namespace Model\Factories;


use Model\Entities\Room;
use Model\Interfaces\FactoryInterface;
use Model\Entities\Screening;
use Model\Interfaces\ObjectToArrayInterface;

class ScreeningFactory implements FactoryInterface
{

    public function create(array $data) : ObjectToArrayInterface
    {
        return new Screening($data['id'], $data['date'], new Room($data['room_id'], $data['room_name'], $data['capacity']), $data['booked_seats']);
    }
}