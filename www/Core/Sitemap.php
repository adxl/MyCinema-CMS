<?php

namespace App\Core;

use App\Models\Event as EventModel;
use App\Models\Room as RoomModel;

class Sitemap
{
    public static function generate()
    {
        $events = Sitemap::getEventsURLs();
        $rooms = Sitemap::getRoomsURLs();

        $urls = [
            "/" => ["locations" => [], "query" => null],
            "/events" => ["locations" => $events, "query" => "id"],
            "/rooms" => ["locations" => $rooms, "query" => "id"],
        ];

        $locations = Sitemap::buildLocations($urls);
        $xml = Sitemap::buildXML($locations);

        Sitemap::buildFile($xml);
    }

    private static function getEventsURLs()
    {
        $eventModel = new EventModel();
        $events = $eventModel->findAll([]);
        $ids = array_map(function ($event) {
            return  $event['id'];
        }, $events);

        return $ids;
    }

    private static function getRoomsURLs()
    {
        $roomModel = new RoomModel();
        $rooms = $roomModel->findAll([]);
        $ids = array_map(function ($room) {
            return  $room['id'];
        }, $rooms);

        return $ids;
    }

    private static function buildLocations($urlData)
    {
        $http = "localhost:8080";
        $locations = [];
        foreach ($urlData as $base => $content) {
            $locations[] = $http . $base;
            $queryParam = $content['query'] ? "?" . $content['query'] . "=" : "";
            foreach ($content['locations'] as $location) {
                $locations[] = $http . $base . $queryParam . $location;
            }
        }

        return $locations;
    }

    private static function buildXML($locations)
    {
        $header = "<!--?xml version='1.0' encoding='UTF-8'?--> ";

        $urlsetStart = "<urlset xmlns='http://www.sitemaps.org/schemas/sitemap/0.9'>";
        $urlsetEnd = "</urlset>";

        $urls = "";
        foreach ($locations as $location) {
            $urls .= "<url><loc>" . $location . "</loc></url>";
        }

        return $urlsetStart . $urls . $urlsetEnd;
    }

    private static function buildFile($xml)
    {
        $file = "sitemap.xml";
        file_put_contents($file, $xml);

        if (file_exists($file)) {
            header('Content-Type: application/xml');
            header('Expires: 0');
            header('Content-Length: ' . filesize($file));
            readfile($file);
            die();
        }
    }
}
