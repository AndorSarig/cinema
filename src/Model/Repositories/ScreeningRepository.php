<?php

namespace Model\Repositories;


use Countable;
use Model\Entities\Room;
use Model\Entities\Screening;
use Model\Factories\CollectionFactory;
use Model\Factories\ScreeningFactory;
use PDO;


class ScreeningRepository extends Repository
{

    public function getScreeningsForMovie(int $movieId) : Countable
    {
        $pdo                        = $this->db->getPDO();
        $sql                        = $this->getStatementForScreenings();
        $stmt                       = $pdo->prepare($sql);
        $stmt->bindParam(1, $movieId, PDO::PARAM_INT);
        $stmt->execute();
        $data                       = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $screeningFactory           = new ScreeningFactory();
        $screeningCollectionFactory = new CollectionFactory();
        return $screeningCollectionFactory->createCollection($screeningFactory, $data);
    }

    public function getScreeningById(int $screeningId) : Screening
    {
        $pdo    = $this->db->getPDO();
        $sql    = $this->getStatementForScreeningById();
        $stmt   = $pdo->prepare($sql);
        $stmt->bindParam(1, $screeningId, PDO::PARAM_INT);
        $stmt->execute();
        $data   = $stmt->fetch(PDO::FETCH_ASSOC);
        return new Screening($data['id'], $data['date'],
            new Room($data['room_id'], $data['room_name'], $data['room_capacity']), $data['booked_seats']);
    }

    public function getFreeSeatsForScreenings() : array
    {
        $pdo    = $this->db->getPDO();
        $sql    = $this->getStatementForFreeSeatsNumber();
        $stmt   = $pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private function getStatementForScreenings() : string
    {
        return "
            SELECT
              screening.id,
              screening.date,
              room.id AS room_id,
              room.name AS room_name,
              room.capacity,
              (SELECT group_concat(seat_id) FROM reservation WHERE screening.id=reservation.screening_id) AS booked_seats
            FROM
              screening
              INNER JOIN room ON screening.room_id = room.id
            WHERE
              movie_id = ?
              AND date > NOW()
        ";
    }

    private function getStatementForScreeningById() : string
    {
        return "
            SELECT
              screening.id,
              screening.date,
              screening.room_id,
              room.name AS room_name,
              room.capacity AS room_capacity,
              group_concat(reservation.seat_id) AS booked_seats
            FROM
              screening
              LEFT JOIN room ON room.id = screening.room_id
              LEFT JOIN reservation ON reservation.screening_id = screening.id
            WHERE
              screening.id = ? AND screening.date > NOW()
        ";
    }

    private function getStatementForFreeSeatsNumber() : string
    {
        return "
            SELECT
              screening.id,
              room.capacity - COUNT(reservation.id) AS free_seats
            FROM
              screening
              LEFT JOIN reservation ON screening.id = reservation.screening_id
              LEFT JOIN room ON screening.room_id = room.id
            WHERE
              screening.date > NOW()
            GROUP BY
              screening.id
        ";
    }
}