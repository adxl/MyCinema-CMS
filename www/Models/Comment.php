<?php

namespace App\Models;

use App\Core\Database;

class Comment extends Database
{
    private $id = null;

    protected $name;
    protected $content;
    protected $eventId;
    protected $date;
    protected $status = "WAITING";

    public function __construct()
    {
        parent::__construct();
    }

    // id
    public function getId()
    {
        return $this->id;
    }
    public function setId($id): void
    {
        $this->id = $id;
    }

    public function getName()
    {
        return $this->name;
    }
    public function setName($name)
    {
        $this->name = $name;
    }

    public function getContent()
    {
        return $this->content;
    }
    public function setContent($content)
    {
        $this->content = $content;
    }

    public function getEventId()
    {
        return $this->eventId;
    }
    public function setEventId($eventId)
    {
        $this->eventId = $eventId;
    }

    public function getDate()
    {
        return $this->date;
    }
    public function setDate($date)
    {
        $this->date = $date;
    }

    public function getStatus()
    {
        return $this->status;
    }
    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function formBuilderComment($eventId)
    {
        return  [
            "config" => [
                "method" => "POST",
                "action" => "/comments/add?id=" . $eventId,
                "id" => "form_comment",
                'class' => 'w-75',
                "submit" => "Envoyer",
                "submitClass" => "w-50 pt-m pb-m"
            ],
            "inputs" => [
                "name" => [
                    "type" => "text",
                    'class' => 'field w-50',
                    "placeholder" => "",
                    "label" => "Votre nom",
                ],

                "content" => [
                    "type" => "textarea",
                    'class' => 'field w-100',
                    "placeholder" => "",
                    "label" => "Commentaire",
                    "minLength" => "20",
                    "maxLength" => "200",
                    "required" => true,
                ],
            ]
        ];
    }
}
