<?php

namespace App\Controllers;

use App\Core\Database;
use App\Core\View;

// use App\Core\FormValidator;
use App\Models\Room as RoomModel;
// use App\Models\Page;

class RoomsController
{

    public function showRoomsAction()
    {

        $view = new View("rooms");
        $view->assign("title", 'Rooms Management');

        $rooms = [
            [
                "label" => "Bercy",
                "capacity" => 3000
            ],
            [
                "label" => "Opéra",
                "capacity" => 3000
            ],
            [
                "label" => "Créteil",
                "capacity" => 94000
            ],
            [
                "label" => "Bonneuil",
                "capacity" => 2
            ],
            [
                "label" => "Bercy",
                "capacity" => 3000
            ],
            [
                "label" => "Opéra",
                "capacity" => 3000
            ],
            [
                "label" => "Créteil",
                "capacity" => 94000
            ],
            [
                "label" => "Bonneuil",
                "capacity" => 2
            ], [
                "label" => "Bercy",
                "capacity" => 3000
            ],
            [
                "label" => "Opéra",
                "capacity" => 3000
            ],
            [
                "label" => "Créteil",
                "capacity" => 94000
            ],
            [
                "label" => "Bonneuil",
                "capacity" => 2
            ], [
                "label" => "Bercy",
                "capacity" => 3000
            ],
            [
                "label" => "Opéra",
                "capacity" => 3000
            ],
            [
                "label" => "Créteil",
                "capacity" => 94000
            ],
            [
                "label" => "Bonneuil",
                "capacity" => 2
            ]
        ];

        $view->assign("rooms", $rooms);
    }

    public function showOneRoomAction($id)
    {
        $view = new View('room', 'front');

        $room = new RoomModel();

        $data = $room->findById($id);

        $view->assign("title", "Salle " . $data['label']);
        $view->assign("data", $data);
    }

    public function createRoom()
    {
        $room = new RoomModel();

        $room->setLabel("Bercy");
        $room->setCapacity(3000);

        $room->save();
    }
}
