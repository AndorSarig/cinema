<?php

use Room\Room;


class RoomFactory
{
    public function create(array $data) : ObjectToArrayInterface
    {
        return new Room($data['id'], $data['name'], $data['capacity']);
    }
}