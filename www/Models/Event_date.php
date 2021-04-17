<?php

namespace App\Models;

use App\Core\Database;
use App\Models\Room as RoomModel;
use App\Models\Event as EventModel;

class Event_date extends Database
{

    protected $event;
    protected $room;
    protected $date;

    public function __construct()
    {
        parent::__construct();
    }

    // event

    public function getEvent()
    {
        return $this->event;
    }
    public function setEvent(int $eventId): void
    {
        $eventModel = new EventModel();
        $event = $eventModel->findById($eventId);

        if ($event) {
            $this->event = $event;
        }
    }

    // room

    public function getRoom()
    {
        return $this->room;
    }
    public function setRoom(int $roomId): void
    {
        $roomModel = new RoomModel();
        $room = $roomModel->findById($roomId);

        if ($room) {
            $this->room = $room;
        }
    }

    // date

    public function getDate(): string
    {
        return $this->date;
    }
    public function setDate(string $date): void
    {
        $this->date = $date;
    }
}
