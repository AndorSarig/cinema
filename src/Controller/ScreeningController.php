<?php
/**
 * Created by PhpStorm.
 * User: andorsarig
 * Date: 16.08.2018
 * Time: 19:34
 */

namespace Controller;


use View\Renderer;
use Model\Repositories\ScreeningRepository;

class ScreeningController
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
        $pageToRender   = 'src/View/templates/new-booking.phtml';
        $output         = $renderer->render($pageToRender, ["screening" => $screening]);
        $output         = $renderer->render('src/View/templates/index.phtml', ["containerContent" => $output]);
        echo $output;
    }
}