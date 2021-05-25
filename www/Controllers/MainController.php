<?php

namespace App\Controllers;

use App\Core\View;
use App\Core\Helpers;
use App\Core\Mailer;

use App\Models\Event;
use App\Models\Room;

class MainController
{

    public function showHomePageAction()
    {
        $view = new View("f_home", 'front');

        echo Helpers::generatePassword();
    }

    public function showEventsAction()
    {
        $id = Helpers::getQueryParam('id');

        if ($id) {
            $this->showOneEventAction($id);
        } else {
            $this->showAllEventsAction();
        }
    }

    public function showAllEventsAction()
    {
        $view = new View("f_events", 'front');

        $eventModel = new Event();

        $events = $eventModel->findAll();
        shuffle($events);
        $events = array_slice($events, 0, 10);

        foreach ($events as &$event) {
            $event['tags'] = $eventModel->getTags($event['id']);
        }

        $nextEvent = $eventModel->getNextEvent();

        $incomingEvents = $eventModel->getIncomingEvents();
        shuffle($incomingEvents);
        $incomingEvents = array_slice($incomingEvents, 0, 4);

        $view->assign('events', $events);
        $view->assign('nextEvent', $nextEvent);
        $view->assign('incomingEvents', $incomingEvents);
    }

    public function showOneEventAction($id)
    {
        $view = new View("f_event", 'front');

        $eventModel = new Event();
        $event = $eventModel->findById($id);

        $view->assign('event', $event);
    }


    public function showRoomsAction()
    {
        $id = Helpers::getQueryParam('id');

        if ($id) {
            $this->showOneRoomAction($id);
        } else {
            $this->showAllRoomsAction();
        }
    }

    public function showAllRoomsAction()
    {
        $view = new View("f_rooms", 'front');

        $roomModel = new Room();
        $rooms = $roomModel->findAll();

        $view->assign('rooms', $rooms);
    }

    public function showOneRoomAction($id)
    {
        $view = new View("f_room", 'front');

        $roomModel = new Room();
        $room = $roomModel->findById($id);

        $view->assign('room', $room);
    }


    public function page404Action()
    {
        $view = new View("f_404", 'front');
    }
}
