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
    }

    public function createRoom()
    {
        $room = new RoomModel();

        $room->setLabel("La Cigale");
        $room->setCapacity(1000);

        $room->save();
    }
}
