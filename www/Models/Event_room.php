<?php

namespace App\Models;

use App\Core\Database;

class Event_room extends Database
{
    private $id = null;

    protected $eventId;
    protected $roomId;
    protected $startTime;
    protected $endTime;

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

    // event
    public function getEventId()
    {
        return $this->event;
    }
    public function setEventId($eventId)
    {
        $this->eventId = $eventId;
    }

    // room
    public function getRoom()
    {
        return $this->room;
    }
    public function setRoom($roomId)
    {
        $this->roomId = $roomId;
    }

    // start
    public function getStartTime()
    {
        return $this->startTime;
    }
    public function setStartTime($startTime)
    {
        $this->startTime = $startTime;
    }

    // end
    public function getEndTime()
    {
        return $this->endTime;
    }
    public function setEndTime($endTime)
    {
        $this->endTime = $endTime;
    }
}
