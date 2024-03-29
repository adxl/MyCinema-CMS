<?php

namespace App\Models;

use App\Core\Database;

class Event_tag extends Database
{
    private $id = null;

    protected $eventId;
    protected $tag;

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

    public function getEventId()
    {
        return $this->eventId;
    }
    public function setEventId($eventId)
    {
        $this->eventId = $eventId;
        return $this;
    }

    public function getTag()
    {
        return $this->tag;
    }
    public function setTag($tag)
    {
        $this->tag = $tag;
        return $this;
    }
}
