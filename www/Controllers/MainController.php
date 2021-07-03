<?php

namespace App\Controllers;

use App\Core\View;
use App\Core\Helpers;

use App\Models\Comment;
use App\Models\Event;
use App\Models\Room;

class MainController
{

    public function showHomePageAction()
    {
        $view = new View("f_home", 'front');
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



        $nextEvent = $eventModel->getNextEvent();

        $incomingEvents = $eventModel->getIncomingEvents();
        shuffle($incomingEvents);
        $incomingEvents = array_slice($incomingEvents, 0, 5);

        $view->assign('nextEvent', $nextEvent);
        $view->assign('incomingEvents', $incomingEvents);
    }

    public function showOneEventAction($id)
    {
        $view = new View("f_event", 'front');

        $eventModel = new Event();
        $event = $eventModel->findById($id);

        $event['tags'] = $eventModel->getTags($event['id']);

        $commentModel = new Comment();
        $commentForm = $commentModel->formBuilderComment($id);
        $comments = $commentModel->findAll([
            'where' => [
                [
                    'column' => 'eventId',
                    'operator' => '=',
                    'value' => $id
                ],
                [
                    'column' => 'status',
                    'operator' => '=',
                    'value' => 'APPROVED'
                ]
            ]
        ]);



        $view->assign('event', $event);
        $view->assign('commentForm', $commentForm);
        $view->assign('comments', $comments);
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

        $cover_room_key = array_rand($rooms);
        $cover_room = $rooms[$cover_room_key];

        unset($rooms[$cover_room_key]);

        $view->assign('cover_room', $cover_room);
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

    public function page500Action()
    {
        $view = new View("f_500", 'front');
    }
}
