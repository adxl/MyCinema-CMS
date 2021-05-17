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

    public static function now()
    {
        return (new \DateTime())->format('Y-m-d H:i:s');
    }

    public static function uuid()
    {
        return str_ireplace('.', '-', uniqid(uniqid('', true) . '-'));
    }

    public static function redirect($location = '/')
    {
        header("Location: " . $location);
    }

    public static function splitFields($fieldsString)
    {
        $fields = explode(';', $fieldsString);
        $result = array_map('trim', $fields);
        return  array_filter($result);
    }

    public static function unsplitFields($fieldsArray)
    {
        $fields = implode('; ', $fieldsArray);
        return  $fields;
    }
}
