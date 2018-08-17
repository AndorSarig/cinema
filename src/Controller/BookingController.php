<?php
/**
 * Created by PhpStorm.
 * User: andorsarig
 * Date: 16.08.2018
 * Time: 19:21
 */

namespace Controller;


use Model\Factories\BookingFactory;
use Model\Factories\CollectionFactory;
use Model\Helpers\Mailer;
use Model\Helpers\URIIterperer;
use Model\Repositories\UserRepository;
use View\Renderer;
use Model\Repositories\BookingRepository;
use Model\Repositories\ScreeningRepository;

class BookingController
{
    public function getBookingPageForScreening() : void
    {
        if (!isset($_SESSION['user-id'])) {
            $_SESSION['redirected-from'] = $_SERVER['REQUEST_URI'];
            header('Location: /login/');
        }
        $screeningRepo  = new ScreeningRepository();
        $screeningId    = URIIterperer::getIdFromURIFor('screening', $_SESSION['REQUEST_URI']);
        $screening      = $screeningRepo->getScreeningById($screeningId);
        $renderer       = new Renderer();
        $pageToRender   = 'src/View/new-booking.phtml';
        $output         = $renderer->render($pageToRender, ["screening" => $screening]);
        $output         = $renderer->render('src/View/templates/index.phtml', ["containerContent" => $output]);
        echo $output;
    }

    public function addBooking() : void
    {
        $repo           = new BookingRepository();
        $screeningId    = URIIterperer::getIdFromURIFor('screening', $_SERVER['REQUEST_URI']);
        $repo->insertBooking([
            "user_id"       => $_SESSION['user-id'],
            "screening_id"  => $screeningId,
            "seat_id"       => $_POST['seat']
        ]);
        $mailer         = new Mailer();
        $userRepo       = new UserRepository();
        $mailer->sendReservationMail($userRepo->getUserEmail($_SESSION['user-id']));
        header('Location: /bookings/');
    }

    public function getBookingsForUser() : void
    {
        if (!isset($_SESSION['user-id'])) {
            $_SESSION['redirected-from'] = $_SERVER['REQUEST_URI'];
            header('Location: /login/');
        }
        $repo = new BookingRepository();
        $data = $repo->getBookingsForUser();
        $bookingFactory = new BookingFactory();
        $bookingCollectionFactory = new CollectionFactory();
        $bookingCollection = $bookingCollectionFactory->createCollection($bookingFactory, $data);
        $renderer       = new Renderer();
        $pageToRender   = 'src/View/templates/bookings.phtml';
        $output         = $renderer->render($pageToRender, ["bookings" => $bookingCollection]);
        $output         = $renderer->render('src/View/templates/index.phtml', ["containerContent" => $output,]);
        echo $output;
    }
}