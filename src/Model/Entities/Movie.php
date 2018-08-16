<?php

namespace Model\Entities;


use Model\Interfaces\ObjectToArrayInterface;

class Movie implements ObjectToArrayInterface
{
    private $id;
    private $titleText;
    private $releaseDate;
    private $genres;
    private $imgURL;
    private $description;


    public function __construct(int $id, string $titleText, int $releaseDate, array $genres, string $imgURL, string $description)
    {
        $this->id           = $id;
        $this->titleText    = $titleText;
        $this->releaseDate  = $releaseDate;
        $this->genres       = $genres;
        $this->imgURL       = $imgURL;
        $this->description  = $description;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTitleText()
    {
        return $this->titleText;
    }

    public function getReleaseDate()
    {
        return $this->releaseDate;
    }

    public function getGenres()
    {
        return $this->genres;
    }

    public function getImgURL(): string
    {
        return $this->imgURL;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getAsArray(): array
    {
        return [
            "id" => $this->id,
            "title" => $this->titleText,
            "releaseDate" => $this->releaseDate,
            "genre" => $this->genres
        ];
    }
}