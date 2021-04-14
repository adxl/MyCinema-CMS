<?php

namespace App\Controllers;

use App\Core\View;
use App\Core\Helpers;

use App\Models\Event as EventModel;

class EventsController
{

    public function defaultAction()
    {
        $id = Helpers::getQueryParam('id');

        if ($id) {
            $this->showOneEventAction($id);
        } else {
            $this->showEventsAction();
        }
    }


    public function showEventsAction()
    {
        $view = new View("events");
        $view->assign("title", 'Events management');

        $eventModel = new EventModel();
        $events = $eventModel->findAll();

        foreach ($events as $key => $event) {
            $eventId = $event['id'];
            $events[$key]['type'] = $eventModel->getType($event['id_type']);
            $events[$key]['rooms'] = $eventModel->getRooms($eventId);
            $events[$key]['sessions'] = $eventModel->getSessionsCount($eventId);
            $events[$key]['next_session'] = $eventModel->getNextSessionDate($eventId);
            $events[$key]['has_passed'] = $eventModel->hasPassed($eventId);
        }


        $view->assign("events", $events);
    }

    public function showCreateEventAction()
    {
        $view = new View("events_create");
        $view->assign("title", 'Events management > Create');
    }
}
