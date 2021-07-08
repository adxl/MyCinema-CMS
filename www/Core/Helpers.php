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

    public static function now($hours = 0)
    {
        $now = new \DateTime();
        $now->add(new \DateInterval("PT{$hours}H"));
        return $now->format('Y-m-d H:i:s');
    }

    public static function uuid()
    {
        return str_ireplace('.', '-', uniqid(uniqid('', true) . '-'));
    }

    public static function slugify($str)
    {
        $bad_characters = [' ', '-', ',', '\'', '/', ':'];
        return strtolower(str_ireplace($bad_characters, '_', $str));
    }

    public static function redirect($location = '/')
    {
        header("Location: " . $location);
    }

    public static function storeAlert(array $messages, bool $type = false)
    {
        $type = $type ? 'success' : 'errors';
        $_SESSION['ALERT'][$type] = $messages;
    }

    public static function getAlert()
    {
        if (isset($_SESSION['ALERT'])) {
            $alert = $_SESSION['ALERT'];
            if (isset($alert['success']))
                return ["type" => "success", "messages" => $alert['success']];
            if (isset($alert['errors']))
                return ["type" => "errors", "messages" => $alert['errors']];
        }
    }

    public static function emptyAlert()
    {
        if (isset($_SESSION['ALERT']))
            unset($_SESSION['ALERT']);
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

    public static function extractDate($datetime)
    {
        return substr($datetime, 0, 10);
    }

    public static function extractTime($datetime)
    {
        return substr($datetime, 11, 5);
    }

    public static function formatDate($date)
    {
        $dateArray = explode('-', $date);

        $day = $dateArray[2];
        $month = $dateArray[1];
        $year = $dateArray[0];

        $months = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Decembre'];

        return "$day " . $months[$month - 1] . " $year";
    }

    public static function formatTime($time)
    {
        return str_replace(':', ' h ', $time);
    }

    public static function toDate($dateString)
    {
        $date = Helpers::formatDate(Helpers::extractDate($dateString));
        $time = Helpers::formatTime(Helpers::extractTime($dateString));

        return "$date - $time";
    }

    public static function generatePassword($length = 8)
    {
        $characters = '123456789abcdefghijkmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ';
        $password = '';
        for ($i = 0; $i < $length; $i++) {
            $password .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $password;
    }
}
