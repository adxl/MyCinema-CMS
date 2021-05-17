<?php

namespace App\Models;

use App\Core\Database;

class Session extends Database
{

    private $id = null;

    protected $userId;
    private $expireAt;   //TODO: changer en protected pour session à temps fixe

    public function __construct()
    {
        parent::__construct();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    public function getExpireAt()
    {
        return $this->expireAt;
    }

    public function setExpireAt($expireAt)
    {
        $this->expireAt = $expireAt;

        return $this;
    }
}
