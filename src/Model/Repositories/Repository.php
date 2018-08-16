<?php

namespace Model\Repositories;


use Model\Repositories\Database\Connection;


class Repository
{
    public function __construct()
    {
        $this->db = new Connection();
    }

    public function insert(array $data, string $sql) : void
    {
        $pdo = $this->db->getPDO();
        $stmt = $pdo->prepare($sql);
        foreach($data as $colName => $value) {
            $stmt->bindValue($colName, $value);
        }
        $stmt->execute();
    }
}