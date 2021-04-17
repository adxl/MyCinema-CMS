<?php

namespace App\Core;


class Helpers
{

    public static function getQueryParam($param)
    {
        $queryString = $_SERVER["QUERY_STRING"];
        parse_str($queryString, $queryParams);

        if (array_key_exists($param, $queryParams))
            return $queryParams[$param];
        return null;
    }
}
