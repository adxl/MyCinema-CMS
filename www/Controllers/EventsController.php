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
            $events[$key]['nextSession'] = $eventModel->getNextSessionDate($eventId);
            $events[$key]['hasPassed'] = $eventModel->hasPassed($eventId);
            $events[$key]['tags'] = $eventModel->getTags($eventId);
        }

        $view->assign("events", $events);
    }

    public function showOneEventAction($id)
    {
        if ($id) {
            $eventModel = new EventModel();
            $event = $eventModel->findById($id);

            if ($event) {
                $view = new View('event', 'front');

                $view->assign("title", $event['title']);
                $view->assign("event", $event);

                return;
            }
        }
        $view = new View('404', 'front');
    }

    public function showCreateEventAction()
    {
        $view = new View("events_create");
        $view->assign("title", 'Events management > Create');

        $eventModel = new EventModel();
        $form = $eventModel->formBuilderCreate();

        $view->assign('form', $form);
    }

    public function addFormAction()
    {
        $view = new View("events_create", false);
        $view->assign("title", 'Events management > Create');

        $eventModel = new EventModel();
        $form = $eventModel->formBuilderCreate();

        $view->assign('form', $form);
    }

    public function showEditEventAction()
    {
        $id = Helpers::getQueryParam('id');

        if ($id) {
            $eventModel = new EventModel();
            $event = $eventModel->findById($id);

            if ($event) {
                $view = new View("events_edit");
                $view->assign("title", 'Event Management > Edit Event');

                $form = $eventModel->formBuilderUpdate($event);
                $view->assign('form', $form);

                session_start();
                $_SESSION['event_id'] = $id;

                return;
            }
        }
        $view = new View('404', 'front');
    }
}
