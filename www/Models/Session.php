<?php

namespace App\Models;

use App\Core\Database;
use App\Core\Helpers;

class Session extends Database
{

    private $id = null;

    protected $userId;
    protected $expireAt;

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

    public function setExpireAt($expiresIn)
    {
        $this->expireAt = Helpers::now($expiresIn);
    }
}
