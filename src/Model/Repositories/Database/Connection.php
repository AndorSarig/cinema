<?php

namespace Model\Repositories\Database;


use PDO;

require_once 'src/configs.php';

class Connection
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = new PDO(DSN, DB_USER, DB_PASSWD);
    }

    public function getPDO()
    {
        return $this->pdo;
    }
}