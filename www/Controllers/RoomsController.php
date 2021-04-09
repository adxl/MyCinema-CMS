<?php

namespace App\Controllers;

use App\Core\View;

// use App\Core\FormValidator;
use App\Models\Room as RoomModel;
// use App\Models\Page;

class RoomsController
{

    public function showRoomsAction()
    {
        // $view = new View("rooms");
        // $view->assign("title", 'Rooms Management');

        $room = new RoomModel();
//        $this->createRoom();
		echo '<pre>';
//        $selectedRoom = $room->findAll(["label", "capacity"]);
//        $room->findById(["label", "capacity"]);
        $selectedRoom = $room->findOne(["label" => "Bercy"]);
        print_r($selectedRoom);
        $room = new RoomModel();
        $room->setId($selectedRoom['id']);
        $room->setLabel($selectedRoom['label']);
        $room->setCapacity($selectedRoom['capacity']);

        $room->save();
    }

    public function createRoom()
    {
        $room = new RoomModel();

        $room->setLabel("Bonneuil");
        $room->setCapacity(2);

        $room->save();
    }
}
