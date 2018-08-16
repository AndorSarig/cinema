<?php
/**
 * Created by PhpStorm.
 * User: andorsarig
 * Date: 09.08.2018
 * Time: 15:38
 */

namespace Model\uploader;


use Model\Interfaces\Uploader;
use Model\Repositories\Database\Connection;

class UploadScreening implements Uploader
{
    private $dataArray;
    private $conn;

    public function __construct(array $data)
    {
        $this->dataArray = $data;
        $this->conn = new Connection();
    }

    public function upload() : void
    {
        $pdo    = $this->conn->getPDO();
        $sql    = $this->generateSQL($this->dataArray);
        $pdo->exec($sql);
    }

    private function generateSQL($dataArray) : string
    {
        $pdo    = $this->conn->getPDO();
        return "INSERT INTO `screening` (`movie_id`, `room_id`, `date`) VALUES ({$pdo->quote($dataArray['movie'])},{$pdo->quote($dataArray['room'])},{$pdo->quote($dataArray['date'])})";
    }
}
