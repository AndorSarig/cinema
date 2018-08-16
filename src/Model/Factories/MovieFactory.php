<?php

namespace Model\Factories;


use Model\Entities\Movie;
use Model\Interfaces\FactoryInterface;
use Model\Interfaces\ObjectToArrayInterface;

class MovieFactory implements FactoryInterface
{
    public function create(array $data) : ObjectToArrayInterface
    {
        return new Movie($data['id'], $data['title'], $data['release_date'], explode(',', $data['genre']),
            $data['img'], $data['description']);
    }
}