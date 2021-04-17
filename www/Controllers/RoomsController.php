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

        foreach ($rooms as $key => $room) {
            $roomId = $room['id'];
            $rooms[$key]['sessions'] = $roomModel->getSessionsCount($roomId);
            $rooms[$key]['nextSession'] = $roomModel->getNextSessionDate($roomId);
            $rooms[$key]['nextMovie'] = $roomModel->getNextEvent($roomId);
        }


        $view->assign("rooms", $rooms);

        //TODO: faut check si user est admin ou pas 
        $isAdmin = true;
        $view->assign("isAdmin", $isAdmin);
    }

    public function showOneRoomAction($id)
    {
        $view = new View('room', 'front');

        $roomModel = new RoomModel();

        $room = $roomModel->findById($id);

        $view->assign("title", "Salle " . $room['label']);
        $view->assign("room", $room);
    }

    public function showCreateRoomAction()
    {
        $view = new View("rooms_create");
        $view->assign("title", 'Rooms Management > Create Room');
    }


    public function showEditRoomAction()
    {
        $id = Helpers::getQueryParam('id');
        if ($id) {
            $roomModel = new RoomModel();
            $room = $roomModel->findById($id);

            if ($room) {
                $view = new View("rooms_edit");
                $view->assign("title", 'Rooms Management > Edit Room');
                return;
            }
        }
        $view = new View('404');
    }

    public function createRoom()
    {
        // $room = new RoomModel();

        // $room->setLabel("Bercy");
        // $room->setCapacity(3000);

        // $room->save();
    }
}
