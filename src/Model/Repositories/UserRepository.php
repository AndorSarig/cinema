<?php

namespace Model\Repositories;


use PDO;


class UserRepository extends Repository
{

    public function uploadUserData() : void
    {
        $sql    = "INSERT INTO user (email, password) VALUES (:email, :password)";
        $this->insert(array(
            'email'     => $_POST['email'],
            'password'  => hash('sha256', $_POST['passwd'])
            ), $sql);
    }

    public function checkLoginData() : int
    {
        $pdo = $this->db->getPDO();
        $sql = "SELECT id FROM user WHERE email=:email AND password=:password";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ':email'     => $_POST['email'],
            ':password'  => hash('sha256', $_POST['passwd'])
        ));
        $userId = $stmt->fetch(PDO::FETCH_NUM);
        return isset($userId[0]) ? $userId[0] : -1;
    }

    public function getUserEmail(int $userId) : string
    {
        $pdo = $this->db->getPDO();
        $sql = "SELECT email FROM user WHERE id=:id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ':id'     => $userId
        ));
        $email = $stmt->fetch(PDO::FETCH_NUM);
        return $email[0];
    }
}