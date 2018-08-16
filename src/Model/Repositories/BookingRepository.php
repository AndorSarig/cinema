<?php

namespace Model\Repositories;


use PDO;

class BookingRepository extends Repository
{

    public function insertBooking(array $data) : void
    {
        $sql = $this->getStatementForInsert();
        $this->insert($data, $sql);
    }

    public function getBookingsForUser() : array
    {
        $pdo = $this->db->getPDO();
        $sql = $this->getStatementForUserBookings();
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ":user" => $_SESSION['user-id']
        ));
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    private function getStatementForUserBookings() : string
    {
        return "
            SELECT
              reservation.id AS book_id,
              reservation.seat_id AS book_seat,
              screening.id AS screen_id,
              screening.room_id AS room_id,
              screening.date AS screen_date,
              room.name AS room_name,
              room.capacity AS room_capacity
            FROM
              reservation
              LEFT JOIN screening ON reservation.screening_id = screening.id
              LEFT JOIN room ON screening.room_id = room.id
            WHERE reservation.user_id=:user AND screening.date > NOW()
        ";
    }

    private function getStatementForInsert() : string
    {
        return "
          INSERT INTO
            reservation (user_id, screening_id, seat_id)
          VALUES
            (:user_id, :screening_id, :seat_id)
        ";
    }
}