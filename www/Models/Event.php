<?php

namespace App\Models;

use App\Core\Database;
use App\Core\Helpers;

use App\Models\Room as RoomModel;
use App\Models\Event_room as EventRoomModel;
use App\Models\Event_tag as EventTagModel;

class Event extends Database
{
    private $id = null;

    protected $title;
    protected $synopsis;
    protected $price = 0.0;
    protected $actors;
    protected $directors;

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

    public function getTitle(): string
    {
        return $this->title;
    }
    public function setTitle($title): void
    {
        $this->title = $title;
    }


    public function getPrice()
    {
        return $this->price;
    }
    public function setPrice(float $price)
    {
        $this->price = $price;
    }

    public function getSynopsis()
    {
        return $this->synopsis;
    }
    public function setSynopsis($synopsis)
    {
        $this->synopsis = $synopsis;
    }

    public function getActors()
    {
        return $this->actors;
    }
    public function setActors($actors)
    {
        $this->actors = $actors;
    }

    public function getDirectors()
    {
        return $this->directors;
    }
    public function setDirectors($directors)
    {
        $this->directors = $directors;
    }

    // rooms

    public function getRooms($id): array
    {
        $rooms = [];
        $eventRoomModel = new EventRoomModel();
        $eventRoom = $eventRoomModel->findAll([
            'select' => 'roomId',
            'where' => [
                [
                    'column' => 'eventId',
                    'value' => $id,
                    'operator' => '='
                ]
            ]
        ]);

        if ($eventRoom) {
            $roomModel = new RoomModel();
            foreach ($eventRoom as $eventRoomEntry) {
                $roomId = $eventRoomEntry['roomId'];
                $room = $roomModel->findById($roomId);
                if ($room)
                    array_push($rooms, $room);
            }
        }

        $rooms = array_map("unserialize", array_unique(array_map("serialize", $rooms)));
        return $rooms;
    }

    // les séances prévues
    public function getSessions($id): array
    {
        $eventRoomModel = new EventRoomModel();
        $sessions = $eventRoomModel->findAll([
            'select' => 'roomId as room, startTime, endTime',
            'where' => [
                [
                    'column' => 'eventId',
                    'value' => $id,
                    'operator' => '='
                ]
            ]
        ]);

        $roomModel = new RoomModel();

        foreach ($sessions as $key => $session) {
            $roomId = $session['room'];
            $room = $roomModel->findById($roomId);

            if ($room) {
                $sessions[$key]['room'] = $room['label'];
                $sessions[$key]['date'] = Helpers::extractDate($session['startTime']);
                $sessions[$key]['startTime'] = Helpers::extractTime($session['startTime']);
                $sessions[$key]['endTime'] = Helpers::extractTime($session['endTime']);
            }
        }

        return $sessions;
    }

    // le nombre de séances prévues
    public function getSessionsCount($id): int
    {
        return count($this->getSessions($id));
    }

    // la date la plus proche
    public function getNextSessionDate($id): string
    {
        $eventRoomModel = new EventRoomModel();

        $eventRoom = $eventRoomModel->findAll([
            'select' => '*',
            'where' => [
                [
                    'column' => 'eventId',
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

    // event est passé
    public function hasPassed($id): bool
    {
        $eventRoomModel = new EventRoomModel();
        $eventRoom = $eventRoomModel->findAll([
            'select' => '*',
            'where' => [
                [
                    'column' => 'eventId',
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
                'order' => "ASC"
            ]
        ]);

        return empty($eventRoom);
    }

    public function getTags($id)
    {
        $event = $this->findById($id);
        if ($event) {
            $eventTagModel = new EventTagModel();
            $eventTags = $eventTagModel->findAll([
                'select' => 'tag',
                'where' => [
                    [
                        'column' => 'eventId',
                        'value' => $id,
                        'operator' => '='
                    ],
                ],
            ]);

            $tags = [];
            foreach ($eventTags as $eventTag)
                $tags[] = $eventTag['tag'];

            return $tags;
        }
    }

    public function formBuilderCreate()
    {
        return  [
            "config" => [
                "method" => "POST",
                "action" => "/bo/events/create",
                "class" => "flex-column",
                "id" => "form_create_event",
                "submit" => "Confirm",
                "cancel" => "Cancel",
                "cancel_action" => "/bo/events"
            ],
            "inputs" => [

                "name" => [
                    "type" => "text",
                    'class' => 'field w-75',
                    "label" => "Movie name",
                    "required" => true,
                    "minLength" => 2,
                    "maxLength" => 60,
                    "value" => "Alien", // DEBUG:
                    "error" => "Event name should be between 2 and 60 characters"
                ],

                "session" => [
                    "type" => "session",
                    "class" => "row",
                    "items" => [
                        [
                            "date[]" => [
                                "type" => "date",
                                "placeholder" => "",
                                "label" => "Date",
                                'class' => 'field',
                                "required" => true,
                                "value" => $data['date'] ?? Helpers::extractDate(Helpers::now()) // DEBUG:
                            ],
                            "startTime[]" => [
                                "type" => "time",
                                "placeholder" => "",
                                "label" => "Start time",
                                'class' => 'field',
                                "required" => true,
                                "value" => $data['startTime'] ?? Helpers::extractTime(Helpers::now()) // DEBUG:
                            ],
                            "endTime[]" => [
                                "type" => "time",
                                "placeholder" => "",
                                "label" => "End time",
                                'class' => 'field',
                                "required" => true,
                                "value" => $data['endTime'] ?? Helpers::extractTime(Helpers::now()) // DEBUG:
                            ],
                            "room[]" => [
                                "type" => "select",
                                "placeholder" => "",
                                "label" => "Room",
                                'class' => 'field',
                                "required" => true,
                                "value" => $data['room'] ?? "",
                                "options" => RoomModel::getAvailableRooms()
                            ],
                            "removeSession" => [
                                "type" => "button",
                                "value" => "<i class='far fa-calendar-times'></i>",
                                "class" => "remove-session-btn",
                            ],
                        ],
                    ],
                ],

                "addSession" => [
                    "type" => "button",
                    "value" => "Add session",
                    "id" => "generate-session-btn",
                    'class' => 'link mb-m'
                ],

                "directors" => [
                    "type" => 'text',
                    "placeholder" => "",
                    "label" => "Directed by",
                    'class' => 'field w-75',
                    "value" => "Director 1; Director 2", // DEBUG:
                    "required" => false,
                ],

                "actors" => [
                    "type" => 'text',
                    "placeholder" => "",
                    "label" => "Starring",
                    'class' => 'field w-75',
                    "value" => "Actor 1; Actor 2", // DEBUG:
                    "required" => false,
                ],

                "synopsis" => [
                    "type" => "textarea",
                    "label" => "Synopsis",
                    'class' => 'field w-75',
                    "required" => true,
                    "minLength" => 10,
                    "maxLength" => 300,
                    'rows' => 8,
                    "value" => "Event synopsis est un textarea description film cinema cms projet annuel trois année école", // DEBUG:
                    "error" => "Event synopsis should be between 10 and 300 characters"
                ],

                "tags" => [
                    "type" => 'text',
                    "placeholder" => "",
                    "label" => "Tags",
                    'class' => 'field w-75 mb-xl',
                    "value" => "ACTION; DRAME", // DEBUG:
                    "required" => false,
                ],
            ]
        ];
    }

    public function formBuilderUpdate($data)
    {
        $sessions = $data['sessions'];

        $availableRooms = RoomModel::getAvailableRooms();

        $items = [];
        if (empty($sessions)) {
            $items[] = [
                "date[]" => [
                    "type" => "date",
                    "placeholder" => "",
                    "label" => "Date",
                    'class' => 'field',
                    "required" => true,
                    "value" => null
                ],
                "startTime[]" => [
                    "type" => "time",
                    "placeholder" => "",
                    "label" => "Start time",
                    'class' => 'field',
                    "required" => true,
                    "value" => null
                ],
                "endTime[]" => [
                    "type" => "time",
                    "placeholder" => "",
                    "label" => "End time",
                    'class' => 'field',
                    "required" => true,
                    "value" => null
                ],
                "room[]" => [
                    "type" => "select",
                    "placeholder" => "",
                    "label" => "Room",
                    'class' => 'field',
                    "required" => true,
                    "value" => null,
                    "options" => $availableRooms
                ],
                "removeSession" => [
                    "type" => "button",
                    "value" => "<i class='far fa-calendar-times'></i>",
                    "class" => "remove-session-btn",
                ]
            ];
        }

        foreach ($sessions as $session) {
            $items[] = [
                "date[]" => [
                    "type" => "date",
                    "placeholder" => "",
                    "label" => "Date",
                    'class' => 'field',
                    "required" => true,
                    "value" => $session['date'] ?? ""
                ],
                "startTime[]" => [
                    "type" => "time",
                    "placeholder" => "",
                    "label" => "Start time",
                    'class' => 'field',
                    "required" => true,
                    "value" => $session['startTime'] ?? ""
                ],
                "endTime[]" => [
                    "type" => "time",
                    "placeholder" => "",
                    "label" => "End time",
                    'class' => 'field',
                    "required" => true,
                    "value" => $session['endTime'] ?? ""
                ],
                "room[]" => [
                    "type" => "select",
                    "placeholder" => "",
                    "label" => "Room",
                    'class' => 'field',
                    "required" => true,
                    "value" => $session['room'] ?? "",
                    "options" => $availableRooms
                ],
                "removeSession" => [
                    "type" => "button",
                    "value" => "<i class='far fa-calendar-times'></i>",
                    "class" => "remove-session-btn",
                ]
            ];
        }

        return [
            "config" => [
                "method" => "POST",
                "action" => "/bo/events/update",
                "class" => "",
                "id" => "form_update_event",
                "submit" => "Confirm",
                "cancel" => "Cancel",
                "cancel_action" => "/bo/events"
            ],

            "inputs" => [

                "name" => [
                    "type" => "text",
                    'class' => 'field w-75',
                    "placeholder" => "",
                    "label" => "Movie name",
                    "required" => true,
                    "minLength" => 2,
                    "maxLength" => 60,
                    "value" => $data['title'],
                    "error" => "Event name should be between 2 and 60 characters"
                ],

                "session" => [
                    "type" => "session",
                    "class" => "row",
                    "items" => $items
                ],

                "addSession" => [
                    "type" => "button",
                    "value" => "Add session",
                    "id" => "generate-session-btn",
                    'class' => 'link mb-m'
                ],

                "directors" => [
                    "type" => 'text',
                    "placeholder" => "",
                    "label" => "Directed by",
                    'class' => 'field w-75',
                    "required" => false,
                    "value" => $data['directors'] ?? ""
                ],

                "actors" => [
                    "type" => 'text',
                    "placeholder" => "",
                    "label" => "Starring",
                    'class' => 'field w-75',
                    "required" => false,
                    "value" => $data['actors'] ?? ""
                ],

                "synopsis" => [
                    "type" => "textarea",
                    "label" => "Synopsis",
                    'class' => 'field w-75',
                    "required" => true,
                    "minLength" => 10,
                    "maxLength" => 300,
                    'rows' => 8,
                    "value" => $data['synopsis'],
                    "error" => "Event synopsis should be between 10 and 300 characters"
                ],

                "tags" => [
                    "type" => 'text',
                    "placeholder" => "",
                    "label" => "Tags",
                    'class' => 'field w-75',
                    "required" => false,
                    "value" => $data['tags'] ?? ""
                ],
            ]
        ];
    }
}
