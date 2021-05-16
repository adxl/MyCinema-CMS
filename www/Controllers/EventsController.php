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
        $view = new View("b_events", 'back');
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
                $view = new View('f_event', 'front');

                $view->assign("title", $event['title']);
                $view->assign("event", $event);

                return;
            }
        }
        $view = new View('f_404', 'front');
    }

    public function showCreateEventAction()
    {
        $view = new View("b_events_create", "back");
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

            $event['directed-by'] = Helpers::unsplitFields($eventModel->getDirectors($id));
            $event['starring'] = Helpers::unsplitFields($eventModel->getActors($id));
            $event['tags'] = Helpers::unsplitFields($eventModel->getTags($id));

            if ($event) {
                $view = new View("b_events_edit", "back");
                $view->assign("title", 'Event Management > Edit Event');

                $form = $eventModel->formBuilderUpdate($event);
                $view->assign('form', $form);

                session_start();
                $_SESSION['edit_event_id'] = $id;

                return;
            }
        }
        $view = new View('b_404', 'front');
    }

    public function createEventAction()
    {
        $data = $_POST;

        $data['directed-by'] = Helpers::splitFields($data['directedBy']);
        $data['starring'] = Helpers::splitFields($data['starring']);
        $data['tags'] = Helpers::splitFields($data['tags']);

        echo "<pre>";
        print_r($data);
        echo "</pre>";
        die();
    }
}
