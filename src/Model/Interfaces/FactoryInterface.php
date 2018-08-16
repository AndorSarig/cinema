<?php
/**
 * Created by PhpStorm.
 * User: sarig
 * Date: 12.08.2018
 * Time: 19:47
 */

namespace Model\Interfaces;


interface FactoryInterface
{
    public function create(array $data) : ObjectToArrayInterface;
}