<?php


namespace Model\Helpers;


class URIIterperer
{
    public static function getIdFromURIFor(string $idOf, string $uri) : int
    {
        $pattern = '/^\/' . $idOf . '\/(?<id>\d+)\/?$/';
        $id = [];
        preg_match($pattern, $_SERVER['REQUEST_URI'], $id);
        return $id['id'];
    }
}