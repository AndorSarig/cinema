<?php

namespace Model\Repositories;

use Model\Collection\Collection;
use Model\Entities\Movie;
use Model\Factories\CollectionFactory;
use Model\Factories\MovieFactory;
use Model\Interfaces\ObjectToArrayInterface;
use PDO;

class MovieRepository extends Repository
{
    public function __construct()
    {
        parent::__construct();
        require_once 'src/configs.php';
    }

    public function getAllGenres() : array
    {
        $sql    = "SELECT name FROM genre";
        $pdo    = $this->db->getPDO();
        $stmt   = $pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
    }

    public function getAllMovies(array $filtersAndSorters, int $elementsPerPage) : Collection
    {
        $sql                        = $this->buildAllMoviesSQL($filtersAndSorters, $elementsPerPage);
        $pdo                        = $this->db->getPDO();
        $stmt                       = $pdo->query($sql);
        $data                       = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $movieFactory               = new MovieFactory();
        $moviesCollectionFactory    = new CollectionFactory();
        return $moviesCollectionFactory->createCollection($movieFactory, $data);
    }

    public function getMovieById(int $movieId) : ObjectToArrayInterface
    {
        $pdo    = $this->db->getPDO();
        $sql    = $this->getStatementForMovieById();
        $stmt   = $pdo->prepare($sql);
        $stmt->bindParam(1, $movieId, PDO::PARAM_INT);
        $stmt->execute();
        $data   = $stmt->fetch(PDO::FETCH_ASSOC);
        return new Movie($data['id'], $data['title'], $data['release_date'], explode(',', $data['genre']),
            $data['img'], $data['description']);
    }

    public function getNrOfScreenedMovies() : int
    {
        $sql = "SELECT COUNT(movies.nr) AS movies_in_show FROM (SELECT DISTINCT movie_id AS nr FROM screening WHERE date > NOW()) AS movies;";
        $pdo = $this->db->getPDO();
        $stmt = $pdo->query($sql);
        return $stmt->fetch(PDO::FETCH_COLUMN, 0);
    }

    private function buildAllMoviesSQL(array $filtersAndSorters, int $elementsPerPage) : string
    {
        $sql = $this->getStatementForAllMoviesFiltered();
        $sql = $this->addFiltersToSQL($sql, $filtersAndSorters);
        $sql = $this->addSortToSQL($sql, $filtersAndSorters);
        $sql = $this->addPagination($sql, $filtersAndSorters, $elementsPerPage);
        return $sql;
    }

    private function addSortToSQL(string $sql, array $sorters) : string
    {
        if (!isset($sorters['sort_by_release'])) {
            return $sql;
        }
        return "$sql ORDER BY release_date " . strtoupper($sorters['sort_by_release']);
    }

    private function addFiltersToSQL(string $sql, array $filters) : string
    {
        $pdo = $this->db->getPDO();
        foreach (FILTERS as $filter) {
            if (!empty($_GET[$filter])) {
                $sql = "$sql AND $filter LIKE {$pdo->quote("%$filters[$filter]%")}";
            }
        }
        return $sql;
    }

    private function addPagination(string $sql, array $currentPage, int $elementsPerPage) : string
    {
        $page = isset($currentPage['page']) ? $currentPage['page'] - 1 : 0;
        return "$sql LIMIT " . $elementsPerPage . " OFFSET " . $page * $elementsPerPage;
    }

    private function getStatementForAllMoviesFiltered() : string
    {
        return "
            SELECT * FROM (
            SELECT
              movie.id,
              movie.title,
              movie.release_date,
              movie.img,
              movie.description,
              (
                SELECT
                  group_concat(screening.date)
                FROM
                  screening
                WHERE
                  movie.id = screening.movie_id
                AND
                  screening.date > NOW()
                GROUP BY
                  screening.movie_id
              ) as date,
              (select group_concat(name) as name from genre inner join movie_genre mg on genre.id=mg.genre_id WHERE movie.id=mg.movie_id GROUP BY mg.movie_id) as genre
            FROM
              movie) AS query
            WHERE
              query.date IS NOT NULL
        ";
    }

    private function getStatementForMovieById() : string
    {
        return "
            SELECT
              movie.id,
              movie.title,
              movie.release_date,
              movie.img,
              movie.description,
              group_concat(genre.name ORDER BY genre.name ASC) as genre
            FROM movie
              LEFT JOIN movie_genre ON movie.id = movie_genre.movie_id
              LEFT JOIN genre ON movie_genre.genre_id = genre.id
            WHERE movie.id=?
        ";
    }
}