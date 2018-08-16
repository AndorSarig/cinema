<?php

namespace Model\Collection;


use Countable;
use Iterator;
use Model\Interfaces\ObjectToArrayInterface;

class Collection implements Iterator, ObjectToArrayInterface, Countable
{
    private $objects = [];
    private $position = 0;

    public function addElement(ObjectToArrayInterface $element) : void
    {
        $this->objects[] = $element;
    }

    /**
     * Iterator Methods
     */

    public function current()
    {
        return $this->objects[$this->position];
    }

    public function next()
    {
        $this->position++;
    }

    public function key()
    {
        return $this->position;
    }

    public function valid()
    {
        return isset($this->objects[$this->position]);
    }

    public function rewind()
    {
        $this->position = 0;
    }

    public function getAsArray(): array
    {
        $dataArray = [];
        foreach ($this->objects as $object) {
            $dataArray[] = $object->getAsArray;
        }
        return $dataArray;
    }

    public function isEmpty(): bool
    {
        return empty($this->objects);
    }

    public function count()
    {
        return count($this->objects);
    }
}