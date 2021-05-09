<?php

namespace App\Models;

use App\Core\Database;
use App\Core\Helpers;
use App\Models\Room as RoomModel;
use App\Models\Tag as TagModel;
use App\Models\Actor as ActorModel;
use App\Models\Director as DirectorModel;
use App\Models\EventType as EventTypeModel;
use App\Models\Event_room as EventRoomModel;
use App\Models\Event_tag as EventTagModel;
use App\Models\Event_actor as EventActorModel;
use App\Models\Event_director as EventDirectorModel;

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

        return empty($eventRoom);
    }

    public function getTags($id)
    {
        $event = $this->findById($id);
        if ($event) {
            $eventTagModel = new EventTagModel();
            $eventTags = $eventTagModel->findAll([
                'select' => '*',
                'where' => [
                    [
                        'column' => 'id_event',
                        'value' => $id,
                        'operator' => '='
                    ],
                ],
            ]);

            $tags = [];
            $tagModel = new TagModel();
            foreach ($eventTags as $eventTag) {
                $tag = $tagModel->findById($eventTag['id_tag']);
                if ($tag) {
                    $tags[] = $tag['label'];
                }
            }

            return $tags;
        }
    }

    public function getDirectors($id)
    {
        $event = $this->findById($id);
        if ($event) {
            $eventDirectorModel = new EventDirectorModel();
            $eventDirectors = $eventDirectorModel->findAll([
                'select' => '*',
                'where' => [
                    [
                        'column' => 'id_event',
                        'value' => $id,
                        'operator' => '='
                    ],
                ],
            ]);

            $directors = [];
            $directorModel = new DirectorModel();
            foreach ($eventDirectors as $eventDirector) {
                $director = $directorModel->findById($eventDirector['id_director']);
                if ($director) {
                    $directors[] = $director['name'];
                }
            }

            return $directors;
        }
    }

    public function getActors($id)
    {
        $event = $this->findById($id);
        if ($event) {
            $eventActorModel = new EventActorModel();
            $eventActors = $eventActorModel->findAll([
                'select' => '*',
                'where' => [
                    [
                        'column' => 'id_event',
                        'value' => $id,
                        'operator' => '='
                    ],
                ],
            ]);

            $actors = [];
            $actorModel = new ActorModel();
            foreach ($eventActors as $eventActor) {
                $actor = $actorModel->findById($eventActor['id_actor']);
                if ($actor) {
                    $actors[] = $actor['name'];
                }
            }

            return $actors;
        }
    }

    public function formBuilderCreate()
    {
        return  [
            "config" => [
                "method" => "POST",
                "action" => "/admin/events/create",
                "class" => "flex-column",
                "id" => "form_create_event",
                "submit" => "Confirm",
                "cancel" => "Cancel",
                "cancel_action" => "/admin/events"
            ],
            "inputs" => [

                "name" => [
                    "type" => "text",
                    'class' => 'field w-50',
                    "label" => "Movie name",
                    "required" => true,
                    "minLength" => 2,
                    "maxLength" => 60,
                    "error" => "Event name should be between 2 and 60 characters"
                ],

                "session" => [
                    "type" => "session",
                    "class" => "row",
                    "items" => [
                        "date[]" => [
                            "type" => "date",
                            "placeholder" => "",
                            "label" => "Date",
                            'class' => 'field',
                            "required" => true,
                            "value" => $data['date'] ?? ""
                        ],
                        "start-time[]" => [
                            "type" => "time",
                            "placeholder" => "",
                            "label" => "Start time",
                            'class' => 'field',
                            "required" => true,
                            "value" => $data['start'] ?? ""
                        ],
                        "end-time[]" => [
                            "type" => "time",
                            "placeholder" => "",
                            "label" => "End time",
                            'class' => 'field',
                            "required" => true,
                            "value" => $data['end'] ?? ""
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
                        "remove-session" => [
                            "type" => "button",
                            "value" => "<i class='far fa-calendar-times'></i>",
                            "class" => "remove-session-btn",
                        ],
                    ]
                ],

                "add-session" => [
                    "type" => "button",
                    "value" => "Add session",
                    "id" => "generate-session-btn",
                    'class' => 'link'
                ],

                "directed-by" => [
                    "type" => 'text',
                    "placeholder" => "",
                    "label" => "Directed by",
                    'class' => 'field w-50',
                    "required" => false,
                ],

                "starring" => [
                    "type" => 'text',
                    "placeholder" => "",
                    "label" => "Starring",
                    'class' => 'field w-50',
                    "required" => false,
                ],

                "synopsis" => [
                    "type" => "textarea",
                    "label" => "Synopsis",
                    'class' => 'field w-50',
                    "required" => true,
                    "minLength" => 10,
                    "maxLength" => 300,
                    'rows' => 8,
                    "error" => "Event synopsis should be between 10 and 300 characters"
                ],

                "tags" => [
                    "type" => 'text',
                    "placeholder" => "",
                    "label" => "Tags",
                    'class' => 'field w-50 mb-xl',
                    "required" => false,
                ],
            ]
        ];
    }

    public function formBuilderUpdate($data)
    {
        return [
            "config" => [
                "method" => "POST",
                "action" => "/admin/events/update",
                "class" => "",
                "id" => "form_update_event",
                "submit" => "Confirm",
                "cancel" => "Cancel",
                "cancel_action" => "/admin/events"
            ],

            "inputs" => [

                "name" => [
                    "type" => "text",
                    'class' => 'field w-50',
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
                    "items" => [
                        "date" => [
                            "type" => "date",
                            "placeholder" => "",
                            "label" => "Date",
                            'class' => 'field',
                            "required" => true,
                            "value" => $data['date'] ?? ""
                        ],
                        "start-time" => [
                            "type" => "time",
                            "placeholder" => "",
                            "label" => "Start time",
                            'class' => 'field',
                            "required" => true,
                            "value" => $data['start'] ?? ""
                        ],
                        "end-time" => [
                            "type" => "time",
                            "placeholder" => "",
                            "label" => "End time",
                            'class' => 'field',
                            "required" => true,
                            "value" => $data['end'] ?? ""
                        ],
                        "room" => [
                            "type" => "select",
                            "placeholder" => "",
                            "label" => "Room",
                            'class' => 'field',
                            "required" => true,
                            "value" => $data['room'] ?? "",
                            "options" => RoomModel::getAvailableRooms()
                        ],
                        "remove-session" => [
                            "type" => "button",
                            "value" => "<i class='far fa-calendar-times'></i>",
                            "class" => "remove-session-btn",
                        ],
                    ]
                ],

                "add-session" => [
                    "type" => "button",
                    "value" => "Add session",
                    "id" => "generate-session-btn",
                    'class' => 'link'
                ],

                "directed-by" => [
                    "type" => 'text',
                    "placeholder" => "",
                    "label" => "Directed by",
                    'class' => 'field w-50',
                    "required" => false,
                    "value" => $data['directed-by'] ?? "",
                    // "button" => 'Add'
                ],

                "starring" => [
                    "type" => 'text',
                    "placeholder" => "",
                    "label" => "Starring",
                    'class' => 'field w-50',
                    "required" => false,
                    "value" => $data['starring'] ?? "",
                    // "button" => 'Add'
                ],

                "synopsis" => [
                    "type" => "textarea",
                    "label" => "Synopsis",
                    'class' => 'field w-50',
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
                    'class' => 'field w-50',
                    "required" => false,
                    "value" => $data['tags'] ?? "",
                    // "button" => 'Add'
                ],
            ]
        ];
    }
}
