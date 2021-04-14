<?php

namespace App\Models;

use App\Core\Database;
use App\Models\Event_type as EventTypeModel;
use App\Models\Event_date as EventDateModel;
use App\Models\Room as RoomModel;

class Event extends Database
{

    private $id = null;

    protected $author;
    protected $title;
    protected $price;

    public function __construct()
    {
        parent::__construct();
    }

    // id

    public function getId()
    {
        return $this->id;
    }
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    // author

    public function getAuthor(): string
    {
        return $this->author;
    }
    public function setAuthor(string $author): void
    {
        $this->label = $author;
    }

    // title

    public function getTitle(): string
    {
        return $this->title;
    }
    public function setTitle(int $title): void
    {
        $this->title = $title;
    }

    // price

    public function getPrice(): float
    {
        return $this->price;
    }
    public function setPrice(string $price): void
    {
        $this->price = $price;
    }

    // type

    public function getType($id): string
    {
        $eventTypeModel = new EventTypeModel();
        $eventType = $eventTypeModel->findById($id);

        if ($eventType) {
            return $eventType['label'];
        }
    }

    // rooms

    public function getRooms($id): array
    {

        $rooms = [];
        $eventDateModel = new EventDateModel();
        $eventDate = $eventDateModel->findAll(['id_event' => $id], null);

        if ($eventDate) {
            $roomModel = new RoomModel();
            foreach ($eventDate as $eventDateEntry) {
                $roomId = $eventDateEntry['id_room'];
                $room = $roomModel->findById($roomId);
                if ($room) {
                    array_push($rooms, $room);
                }
            }
        }
        return $rooms;
    }

    // le nombre de séances prévues

    public function getSessionsCount($id): int
    {
        $eventDateModel = new EventDateModel();
        $eventDate = $eventDateModel->findAll(['id_event' => $id], null);

        return $eventDate ? sizeof($eventDate) : 0;
    }

    // la date la plus proche

    public function getNextSessionDate($id): string
    {
        $eventDateModel = new EventDateModel();
        $eventDate = $eventDateModel->findAll(['id_event' => $id], ['column' => 'id_event', 'order' => 'ASC']);

        return $eventDate ? $eventDate[0]['eventDate'] : '';
    }
}
