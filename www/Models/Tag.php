<?php

namespace App\Models;

use App\Core\Database;

class Tag extends Database
{
    private $id = null;

    protected $label;

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


    public function getLabel()
    {
        return $this->label;
    }


    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }
}
