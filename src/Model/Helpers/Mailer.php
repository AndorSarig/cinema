<?php


namespace Model\Helpers;


class Mailer
{

    public function sendReservationMail(string $to)
    {
        $header = "From: EvoCinema <evocinema@gmail.com>\r\n";
        $subject = "Reservation details";
        $message = 'You have a new booking on http://cinema.local/bookings/ ! For more please visit your bookings page!';
        mail($to, $subject, $message, $header);
    }
}