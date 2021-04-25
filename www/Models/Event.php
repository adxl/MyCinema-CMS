<?php

namespace App\Models;

use App\Core\Database;
use App\Core\Helpers;
use App\Models\EventType as EventTypeModel;
use App\Models\Event_room as EventRoomModel;
use App\Models\Room as RoomModel;

class Event extends Database
{
    private $id = null;

    protected $author;
    protected $title;
    protected $price;

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

    // author

    public function getAuthor(): string
    {
        return $this->author;
    }
    public function setAuthor(string $author): void
    {
        $this->label = $author;
    }

    // title

    public function getTitle(): string
    {
        return $this->title;
    }
    public function setTitle(int $title): void
    {
        $this->title = $title;
    }

    // price

    public function getPrice(): float
    {
        return $this->price;
    }
    public function setPrice(string $price): void
    {
        $this->price = $price;
    }

    // type

    public function getType($id): string
    {
        $eventTypeModel = new EventTypeModel();
        $eventType = $eventTypeModel->findById($id);

        if ($eventType) {
            return $eventType['label'];
        }
    }

    // rooms

    public function getRooms($id): array
    {
        $rooms = [];
        $eventRoomModel = new EventRoomModel();
        $eventRoom = $eventRoomModel->findAll([
            'select' => 'id_room',
            'where' => [
                [
                    'column' => 'id_event',
                    'value' => $id,
                    'operator' => '='
                ]
            ]
        ]);

        if ($eventRoom) {
            $roomModel = new RoomModel();
            foreach ($eventRoom as $eventRoomEntry) {
                $roomId = $eventRoomEntry['id_room'];
                $room = $roomModel->findById($roomId);
                if ($room) {
                    array_push($rooms, $room);
                }
            }
        }

        $rooms = array_map("unserialize", array_unique(array_map("serialize", $rooms)));
        return $rooms;
    }

    // le nombre de séances prévues

    public function getSessionsCount($id): int
    {
        $eventRoomModel = new EventRoomModel();
        $eventRoom = $eventRoomModel->findAll([
            'select' => 'COUNT(*) as count',
            'where' => [
                [
                    'column' => 'id_event',
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
                    'column' => 'id_event',
                    'value' => $id,
                    'operator' => '='
                ],
                [
                    'column' => 'eventDate',
                    'value' => Helpers::today(),
                    'operator' => '>='
                ]
            ],
            'order' => [
                'column' => 'eventDate',
                'order' => "DESC"
            ]
        ]);


        return $eventRoom ? $eventRoom[0]['eventDate'] : '';
    }

    // event est passé

    public function hasPassed($id): bool
    {
        $eventRoomModel = new EventRoomModel();
        $eventRoom = $eventRoomModel->findAll([
            'select' => '*',
            'where' => [
                [
                    'column' => 'id_event',
                    'value' => $id,
                    'operator' => '='
                ],
                [
                    'column' => 'eventDate',
                    'value' => Helpers::today(),
                    'operator' => '>='
                ]
            ],
            'order' => [
                'column' => 'eventDate',
                'order' => "ASC"
            ]
        ]);


        return empty($eventRoom) ? "true" : "";
    }

    public function formBuilderCreate()
    {
        return [
            "config" => [
                "method" => "POST",
                "action" => "/events/create",
                "class" => "",
                "id" => "form_create_event",
                "submit" => "Confirm",
                "cancel" => "Cancel",
                "cancel_action" => "/events"
            ],
            "inputs" => [

                "name" => [
                    "type" => "text",
                    "placeholder" => "",
                    "label" => "Movie name",
                    "required" => true,
                    "minLength" => 2,
                    "maxLength" => 60,
                    "error" => "Event name should be between 2 and 60 characters"
                ],

                "synopsis" => [
                    "type" => "textarea",
                    "label" => "Synopsis",
                    "required" => true,
                    "minLength" => 10,
                    "maxLength" => 300,
                    "error" => "Event synopsis should be between 10 and 300 characters"
                ]
            ]
        ];
    }

    public function formBuilderUpdate($data)
    {
        return [
            "config" => [
                "method" => "POST",
                "action" => "/events/update",
                "class" => "",
                "id" => "form_update_event",
                "submit" => "Confirm",
                "cancel" => "Cancel",
                "cancel_action" => "/events"
            ],
            "inputs" => [

                "name" => [
                    "type" => "text",
                    "placeholder" => "",
                    "label" => "Movie title",
                    "required" => true,
                    "minLength" => 2,
                    "maxLength" => 60,
                    "value" => $data['title'],
                    "error" => "Event name should be between 2 and 60 characters"
                ],

                "synopsis" => [
                    "type" => "textarea",
                    "label" => "Synopsis",
                    "required" => true,
                    "minLength" => 10,
                    "maxLength" => 300,
                    "value" => $data['synopsis'],
                    "error" => "Event synopsis should be between 10 and 300 characters"
                ]
            ]
        ];
    }

    public function formBuilderSession($data)
    {
        return [
            "config" => [
                "action" => "#",
                "class" => "",
                "submit" => "Add",
            ],
            "inputs" => [

                "name" => [
                    "type" => "text",
                    "placeholder" => "???",
                    "label" => "date",
                    "required" => true,
                ],
            ]
        ];
    }
}
