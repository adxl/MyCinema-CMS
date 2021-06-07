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

        $eventId = $eventRoom['eventId'];

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
                "action" => "/bo/rooms/create",
                "class" => "flex-column",
                "id" => "form_create_room",
                "submit" => "Confirmer",
                "cancel" => "Annuler",
                "cancel_action" => "/bo/rooms"
            ],
            "inputs" => [

                "name" => [
                    "type" => "text",
                    "placeholder" => "",
                    "label" => "Nom de la salle",
                    "required" => true,
                    'class' => 'field w-25',
                    "minLength" => 2,
                    "maxLength" => 60,
                ],

                "capacity" => [
                    "type" => "number",
                    "label" => "Capacité d'accueil",
                    "required" => true,
                    'class' => 'field w-25',
                ]
            ]
        ];
    }

    public function formBuilderUpdate($data)
    {
        return [
            "config" => [
                "method" => "POST",
                "action" => "/bo/rooms/update",
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
                    'class' => 'field w-25',
                    "minLength" => 2,
                    "maxLength" => 60,
                    "value" => $data['label']
                ],

                "capacity" => [
                    "type" => "number",
                    "label" => "Capacité d'accueil",
                    "required" => true,
                    'class' => 'field w-25',
                    "value" => $data['capacity'],
                    "min" => 0
                ],

                "isAvailable" => [
                    "type" => "checkbox",
                    "label" => "Disponible ?",
                    "required" => false,
                    "class" => "checkbox",
                    "checked" => $data['isAvailable']
                ],

                "isHandicapAccess" => [
                    "type" => "checkbox",
                    "label" => "Accès Handicapés ?",
                    "required" => false,
                    "class" => "checkbox",
                    "checked" => $data['isHandicapAccess']
                ]
            ]
        ];
    }
}
