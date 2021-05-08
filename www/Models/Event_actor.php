<?php

namespace App\Models;

use App\Core\Database;

class Event_actor extends Database
{
    private $id = null;

    protected $event;
    protected $actor;

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


    public function getEvent()
    {
        return $this->event;
    }

    public function setEvent($event)
    {
        $this->event = $event;
        return $this;
    }


    public function getActor()
    {
        return $this->actor;
    }

    public function setActor($actor)
    {
        $this->actor = $actor;
        return $this;
    }
}
