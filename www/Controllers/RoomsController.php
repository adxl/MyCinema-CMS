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

    public function createRoom()
    {
        $room = new RoomModel();

        $room->setLabel("La Cigale");
        $room->setCapacity(1000);


        /*
        
        

<div class="row">
    <?php foreach ($rooms as $room) : ?>

        <div class="card col-6 my-s">
            <p> <?= $room['label']; ?> </p>
        </div>

    <?php endforeach; ?>



</div>
        
        */


        $room->save();
    }
}
