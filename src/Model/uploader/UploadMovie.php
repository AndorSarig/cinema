<?php

namespace Model\uploader;


use Model\Interfaces\Uploader;
use Model\Repositories\Database\Connection;

class UploadMovie implements Uploader {
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
                $this->insertMovie($entry);
                $this->insertGenreForFilm($entry);
            }
        }
    }

    private function checkIfEntryExists($entry) : bool
    {
        $pdo    = $this->conn->getPDO();
        $sql    = "SELECT `title` FROM movie WHERE `title`={$pdo->quote($entry[0])}";
        $stmt   = $pdo->query($sql);
        return empty($stmt->fetchAll());
    }

    private function insertMovie($entry) : void
    {
        $film   = array_slice($entry, 0, 4);
        $pdo    = $this->conn->getPDO();
        $sql    = "
  INSERT INTO `movie` (`title`, `release_date`, `img`, `description`)
  VALUES ({$pdo->quote($film[0])}, {$pdo->quote($film[1])}, {$pdo->quote($film[2])}, {$pdo->quote($film[3])})";
        $pdo->exec($sql);
    }

    private function insertGenreForFilm($entry) : void
    {
        $genre  = array_slice($entry, 4);
        $pdo    = $this->conn->getPDO();
        foreach ($genre as $genreToAdd) {
            $genreToAdd = ucwords($genreToAdd);
            $sql = "INSERT INTO `movie_genre` (`movie_id`, `genre_id`) VALUES ((SELECT `id` FROM `movie` WHERE `title`={$pdo->quote($entry[0])}), (SELECT `id` FROM genre WHERE `name`={$pdo->quote($genreToAdd)}))";
            $pdo->exec($sql);
        }
    }
}