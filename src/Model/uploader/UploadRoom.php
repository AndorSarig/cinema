<?php

namespace Model\uploader;


use Model\Interfaces\Uploader;
use Model\Repositories\Database\Connection;

class UploadRoom implements Uploader
{
    private $dataArray;
    private $conn;

    public function __construct(array $data)
    {
        $this->dataArray    = $data;
        $this->conn         = new Connection();
    }

    public function upload() : void
    {
        foreach ($this->dataArray as $entry) {
            if ($this->checkIfEntryExists($entry) === true) {
                $this->insertRoom($entry);
            }
        }
    }

    private function checkIfEntryExists($entry) : bool
    {
        $pdo    = $this->conn->getPDO();
        $sql    = "SELECT `name` FROM room WHERE `name`={$pdo->quote($entry[0])}";
        $stmt   = $pdo->query($sql);
        return empty($stmt->fetchAll());
    }

    private function insertRoom($entry) : void
    {
        $pdo    = $this->conn->getPDO();
        $sql    = "INSERT INTO `room` (`name`, `capacity`) VALUES ({$pdo->quote($entry[0])}, {$pdo->quote($entry[1])})";
        $pdo->exec($sql);
    }
}