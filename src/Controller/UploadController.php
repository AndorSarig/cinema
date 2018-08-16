<?php
/**
 * Created by PhpStorm.
 * User: andorsarig
 * Date: 07.08.2018
 * Time: 14:02
 */

namespace Controller;


use Exception;
use Model\uploader\ReadCSV;
use Model\uploader\UploadGenre;
use Model\uploader\UploadMovie;
use Model\uploader\UploadRoom;
use Model\uploader\Validators\CSVFileValidator;

/**
 * Class UploadController
 * @package Controller
 * @throws Exception
 */

class UploadController
{
    use ReadCSV;


    /**
     * @param $options
     * @throws Exception
     */
    public function callUploaderForOptions($options) : void
    {
        $validator = new CSVFileValidator();
        foreach ($options as $optionName => $optionValue) {
            switch ($optionName) {
                case 'upload-genre':
                    $validator->validate($optionValue, 1);
                    $this->uploadGenre($optionValue);
                    break;
                case 'upload-movies':
                    $validator->validate($optionValue, 5, true);
                    $this->uploadMovie($optionValue);
                    break;
                case 'upload-rooms':
                    $validator->validate($optionValue, 2);
                    $this->uploadRoom($optionValue);
                    break;
                case 'movie-id':
                    $this->uploadScreening($options);
                    break;
            }
        }
    }

    private function uploadGenre($filename) : void
    {
        $data       = $this->readCSV($filename);
        $uploader   = new UploadGenre($data);
        $uploader->upload();
    }

    private function uploadMovie($filename) : void
    {
        $data       = $this->readCSV($filename);
        $uploader   = new UploadMovie($data);
        $uploader->upload();
    }

    private function uploadRoom($filename) : void
    {
        $data       = $this->readCSV($filename);
        $uploader   = new UploadRoom($data);
        $uploader->upload();
    }

    private function uploadScreening($options) : void
    {
        $data['movie']  = $options['movie-id'];
        $data['date']   = $options['date'];
        $data['room']   = $options['room-id'];
        $uploader       = new UploadScreening($data);
        $uploader->upload();
    }
}
