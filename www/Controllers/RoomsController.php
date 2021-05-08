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
            $this->showEditRoomAction($id);
        } else {
            $this->showRoomsAction();
        }
    }


    public function showRoomsAction()
    {
        $view = new View("b_rooms", 'back');
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
    }

    public function showCreateRoomAction()
    {
        $view = new View("b_rooms_create", 'back');
        $view->assign("title", 'Rooms Management > Create Room');


        $room = new RoomModel();
        $form = $room->formBuilderCreate();

        $view->assign('form', $form);
    }


    public function showEditRoomAction($id = null)
    {
        if (!$id) {
            $id = Helpers::getQueryParam('id');
        }

        if ($id) {
            $roomModel = new RoomModel();
            $room = $roomModel->findById($id);

            if ($room) {
                $view = new View("b_rooms_edit", 'back');
                $view->assign("title", 'Rooms Management > Edit Room');

                $form = $roomModel->formBuilderUpdate($room);
                $view->assign('form', $form);

                session_start();
                $_SESSION['room_id'] = $id;

                return;
            }
        }
        $view = new View('f_404', 'front');
    }

    public function createRoomAction()
    {
        $data = $_POST;

        $room = new RoomModel();
        $room->setLabel($data['name']);
        $room->setCapacity($data['capacity']);

        $room->save();

        header("Location: /rooms");
    }

    public function updateRoomAction()
    {
        session_start();
        $id = $_SESSION['room_id'];
        $data = $_POST;

        $room = new RoomModel();

        $room->setId($id);
        $room->setLabel($data['label']);

        $room->setCapacity($data['capacity']);
        if (isset($_POST['isAvailable'])) {
            $room->setIsAvailable(1);
        } else {
            $room->setIsAvailable(0);
        }

        if (isset($_POST['isHandicapAccess'])) {
            $room->setIsHandicapAccess(1);
        } else {
            $room->setIsHandicapAccess(0);
        }

        $room->save();

        header("Location: /rooms");
    }
}
