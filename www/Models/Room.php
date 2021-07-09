<?php

namespace App\Models;

use App\Core\Database;
use App\Core\Helpers;
use App\Models\Event_room as EventRoomModel;
use App\Models\Event as EventModel;

class Room extends Database
{
    private $id = null;

    protected $label;
    protected $capacity;
    protected $description;
    protected $media;
    protected $isHandicapAccess = 0;
    protected $isAvailable = 1;

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

    // name

    public function getLabel(): string
    {
        return $this->label;
    }
    public function setLabel(string $label): void
    {
        $this->label = $label;
    }

    // capacity

    public function getCapacity(): int
    {
        return $this->capacity;
    }
    public function setCapacity(int $capacity): void
    {
        $this->capacity = $capacity;
    }

    // description

    public function getDescription(): string
    {
        return $this->description;
    }
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    // media 

    public function getMedia(): string
    {
        return $this->media;
    }
    public function setMedia(string $media): void
    {
        $this->media = $media;
    }

    // isHandicapAccess

    public function getIsHandicapAccess(): bool
    {
        return $this->isHandicapAccess;
    }
    public function setIsHandicapAccess($isHandicapAccess): void
    {
        $this->isHandicapAccess = $isHandicapAccess;
    }

    // isAvailable

    public function getIsAvailable(): bool
    {
        return $this->isAvailable;
    }
    public function setIsAvailable($isAvailable): void
    {
        $this->isAvailable = $isAvailable;
    }


    // le nombre de séances prévues

    public function getSessionsCount($id): int
    {
        $eventRoomModel = new EventRoomModel();
        $eventRoom = $eventRoomModel->findAll([
            'select' => 'COUNT(*) as count',
            'where' => [
                [
                    'column' => 'roomId',
                    'value' => $id,
                    'operator' => '='
                ]
            ]
        ]);

        return $eventRoom ? $eventRoom[0]['count'] : 0;
    }

    // la date la plus proche

    public function getNextSessionDate($id): string
    {
        $eventRoomModel = new EventRoomModel();
        $eventRoom = $eventRoomModel->findAll([
            'select' => '*',
            'where' => [
                [
                    'column' => 'roomId',
                    'value' => $id,
                    'operator' => '='
                ],
                [
                    'column' => 'startTime',
                    'value' => Helpers::now(),
                    'operator' => '>='
                ]
            ],
            'order' => [
                'column' => 'startTime',
                'order' => "DESC"
            ]
        ]);


        return $eventRoom ? $eventRoom[0]['startTime'] : '';
    }

    // le nom du prochain event de la room

    public function getNextEvent($id): string
    {
        $nextDate = $this->getNextSessionDate($id);

        $eventRoomModel = new EventRoomModel();
        $eventRoom = $eventRoomModel->findOne([
            'select' => 'eventId',
            'where' => [
                [
                    'column' => 'startTime',
                    'value' => $nextDate,
                    'operator' => '='
                ]
            ]
        ]);

        $eventId = $eventRoom['eventId'] ?? '';

        $eventModel = new EventModel();
        $event = $eventModel->findById($eventId);

        return $event ? $event['title'] : '';
    }


    public static function getAvailableRooms()
    {
        $roomModel = new Room();
        $rooms = $roomModel->findAll([
            'select' => '*',
            'where' => [
                [
                    'column' => 'isAvailable',
                    'operator' => '=',
                    'value' => true
                ],
            ],
        ]);

        $availableRooms = [];

        foreach ($rooms as $room) {
            $availableRooms[] = [
                'id' => $room['id'],
                'label' => $room['label']
            ];
        }

        return $availableRooms;
    }

    public function formBuilderCreate()
    {
        return [
            "config" => [
                "method" => "POST",
                "action" => "/bo/rooms/new",
                "enctype" => 'multipart/form-data',
                "class" => "flex-column",
                "id" => "form_create_room",
                "submit" => "Confirmer",
                "cancel" => "Annuler",
                "cancel_action" => "/bo/rooms"
            ],
            "inputs" => [

                "label" => [
                    "type" => "text",
                    "placeholder" => "",
                    "label" => "Nom de la salle",
                    "required" => true,
                    'class' => 'field w-75',
                    "minLength" => 2,
                    "maxLength" => 60,
                ],

                "description" => [
                    "type" => "textarea",
                    "label" => "Description",
                    'class' => 'field w-100',
                    "required" => true,
                    "minLength" => 10,
                    "maxLength" => 300,
                    'rows' => 3,
                ],

                "capacity" => [
                    "type" => "number",
                    "label" => "Capacité d'accueil",
                    "required" => true,
                    'class' => 'field w-50 mb-xl',
                ],

                "media" => [
                    "type" => "media",
                    "label" => "Photo de la salle",
                    'class' => 'field media',
                ]
            ]
        ];
    }

    public function formBuilderUpdate($data)
    {
        return [
            "config" => [
                "method" => "POST",
                "action" => "/bo/rooms/edit?id=" . $data['id'],
                "enctype" => 'multipart/form-data',
                "class" => "",
                "id" => "form_update_room",
                "submit" => "Confirmer",
                "cancel" => "Annuler",
                "cancel_action" => "/bo/rooms"
            ],
            "inputs" => [

                "label" => [
                    "type" => "text",
                    "placeholder" => "",
                    "label" => "Nom de la salle",
                    "required" => true,
                    'class' => 'field w-75',
                    "minLength" => 2,
                    "maxLength" => 60,
                    "value" => $data['label']
                ],

                "description" => [
                    "type" => "textarea",
                    "label" => "Description",
                    'class' => 'field w-100',
                    "required" => true,
                    "minLength" => 10,
                    "maxLength" => 300,
                    'rows' => 3,
                    "value" => $data['description'],
                ],

                "capacity" => [
                    "type" => "number",
                    "label" => "Capacité d'accueil",
                    "required" => true,
                    'class' => 'field w-50',
                    "value" => $data['capacity'],
                    "min" => 0
                ],

                "media" => [
                    "type" => "media",
                    "label" => "Photo de la salle",
                    'class' => 'field media',
                    'value' => $data['media'],
                ],

                "isAvailable" => [
                    "type" => "checkbox",
                    "label" => "Disponible ?",
                    "class" => "checkbox",
                    "checked" => $data['isAvailable']
                ],

                "isHandicapAccess" => [
                    "type" => "checkbox",
                    "label" => "Accès Handicapés ?",
                    "class" => "checkbox",
                    "checked" => $data['isHandicapAccess']
                ],
            ]
        ];
    }
}
