<?php

use Controller\UploadController;
use Model\Routing\RouteSolver;


class CinemaApplication
{
    public function run()
    {
        if (php_sapi_name() === "cli") {
            try {
                $uploadController   = new UploadController();
                $options            = getopt("", ["upload-genre:", "upload-movies:", "upload-rooms:", "movie-id:", "date:", "room-id:"]);
                $uploadController->callUploaderForOptions($options);
            } catch (Exception $e) {
                echo $e->getMessage() . PHP_EOL;
            }
        } else {
            session_start();
            $routing = new RouteSolver();
            $routing->solve();
        }
    }
}
