<?php
/**
 * Created by PhpStorm.
 * User: andorsarig
 * Date: 16.08.2018
 * Time: 19:30
 */

namespace Controller;


use Model\Repositories\ScreeningRepository;

class AjaxController
{
    public function updateFreeSeats() {
        $screeningRepo = new ScreeningRepository();
        $freeSeats = $screeningRepo->getFreeSeatsForScreenings();
        echo json_encode($freeSeats);
    }
}