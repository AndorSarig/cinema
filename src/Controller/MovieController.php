<?php
/**
 * Created by PhpStorm.
 * User: andorsarig
 * Date: 16.08.2018
 * Time: 18:58
 */

namespace Controller;


use Model\Helpers\URIIterperer;
use View\Renderer;
use Model\Repositories\MovieRepository;
use Model\Repositories\ScreeningRepository;

class MovieController
{
    public function __construct()
    {
        require_once 'src/configs.php';
    }

    public function getAllMovies() : void
    {
        $renderer           = new Renderer();
        $movieRepo          = new MovieRepository();
        $moviesCollection   = $movieRepo->getAllMovies($_GET, ELEMENTS_ON_PAGE);
        $pageToRender       = count($moviesCollection) ? 'src/View/templates/movies.phtml' : 'src/View/templates/no-result.phtml';
        $pageNr             = $movieRepo->getNrOfScreenedMovies() / ELEMENTS_ON_PAGE;
        $pageNr             = $movieRepo->getNrOfScreenedMovies() % ELEMENTS_ON_PAGE ? $pageNr+1 : $pageNr;
        $output             = $renderer->render($pageToRender, [
            "genre" => $movieRepo->getAllGenres(),
            "movies" => $moviesCollection,
            "pageNr" => $pageNr
        ]);
        $output             = $renderer->render('src/View/templates/index.phtml', ["containerContent" => $output]);
        echo $output;
    }

    public function getMovieById() : void
    {
        $movieRepo      = new MovieRepository();
        $movieId        = URIIterperer::getIdFromURIFor('movie', $_SESSION['REQUEST_URI']);        $movie          = $movieRepo->getMovieById($id['id']);
        $screeningRepo  = new ScreeningRepository();
        $screenings     = $screeningRepo->getScreeningsForMovie($movieId);
        $renderer       = new Renderer();
        $pageToRender   = 'src/View/templates/movie.phtml';
        $output         = $renderer->render($pageToRender, [
            "movie" => $movie,
            "screenings" => $screenings
        ]);
        $output         = $renderer->render('src/View/templates/index.phtml', ["containerContent" => $output]);
        echo $output;
    }
}