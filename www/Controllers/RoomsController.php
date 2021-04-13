<?php

namespace App\Controllers;

use App\Core\Database;
use App\Core\View;
use App\Core\Helpers;

// use App\Core\FormValidator;
use App\Models\Room as RoomModel;
// use App\Models\Page;

class RoomsController
{

    public function defaultAction()
    {

        $id = Helpers::getQueryParam('id');

        if ($id) {
            $this->showOneRoomAction($id);
        } else {
            $this->showRoomsAction();
        }
    }


    public function showRoomsAction()
    {

        $view = new View("rooms");
        $view->assign("title", 'Rooms Management');

        $roomModel = new RoomModel();
        $rooms = $roomModel->findAll();

        $view->assign("rooms", $rooms);
    }

    public function showOneRoomAction($id)
    {
        $view = new View('room', 'front');

        $roomModel = new RoomModel();

        $room = $roomModel->findById($id);

        $view->assign("title", "Salle " . $room['label']);
        $view->assign("room", $room);
    }

    public function createRoom()
    {
        $room = new RoomModel();

        $room->setLabel("Bercy");
        $room->setCapacity(3000);

        $room->save();
    }
}
