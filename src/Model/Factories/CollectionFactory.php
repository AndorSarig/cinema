<?php

namespace Model\Factories;


use Model\Collection\Collection;
use Model\Interfaces\FactoryInterface;


class CollectionFactory
{

    public function createCollection(FactoryInterface $factory, array $data) : Collection
    {
        $collection = new Collection();
        foreach ($data as $entry) {
            $collection->addElement($factory->create($entry));
        }
        return $collection;
    }
}