<?php

namespace Model\uploader;


use Model\Interfaces\Uploader;
use Model\Repositories\Database\Connection;

class UploadGenre implements Uploader {

    use ReadCSV;

    private $dataArray;
    private $conn;

    public function __construct(array $data)
    {
        $this->dataArray    = $data;
        $this->conn         = new Connection();
    }

    public function upload() : void
    {
        $pdo    = $this->conn->getPDO();
        $sql    = $this->generateSQL($this->dataArray);
        $pdo->exec($sql);
    }

    private function generateSQL(array $dataArray) : string
    {
        $sql = "INSERT IGNORE INTO `genre` (`name`) VALUES";
        $pdo    = $this->conn->getPDO();
        foreach ($dataArray as $entry) {
            $sql .= " ({$pdo->quote(ucwords($entry[0]))}),";
        }
        return trim($sql, ',');
    }

}
