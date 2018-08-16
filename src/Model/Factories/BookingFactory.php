<?php

namespace Model\Factories;


use Model\Entities\Booking;
use Model\Entities\Room;
use Model\Entities\Screening;
use Model\Interfaces\FactoryInterface;
use Model\Interfaces\ObjectToArrayInterface;

class BookingFactory implements FactoryInterface
{
    public function create(array $data) : ObjectToArrayInterface
    {
        return new Booking($data['book_id'], new Screening($data['screen_id'], $data['screen_date'],
            new Room($data['room_id'], $data['room_name'], $data['room_capacity'])), $data['book_seat']);
    }
}