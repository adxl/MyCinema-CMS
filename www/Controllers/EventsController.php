<?php

namespace App\Controllers;

use App\Core\View;
use App\Core\Helpers;
use App\Models\Event as EventModel;
use App\Models\Event_room;
use App\Models\Tag as TagModel;
use App\Models\Event_tag as EventTagModel;

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

            if ($event) {
                $_SESSION['edit_event_id'] = $id;

                $view = new View("b_events_edit", "back");
                $view->assign("title", 'Event Management > Edit Event');

                $event['sessions'] = $eventModel->getSessions($id);
                $event['tags'] = Helpers::unsplitFields($eventModel->getTags($id));

                $form = $eventModel->formBuilderUpdate($event);
                $view->assign('form', $form);

                return;
            }
        }
        $view = new View('b_404', 'front');
    }

    public function createEventAction()
    {
        $data = $_POST;

        /**
         *  créer event x
         *  créer tags if not exist x
         *  joiture event - tag x
         *  joiture event - room x
         */

        // insert event
        $event = new EventModel();
        $event->setTitle($data['name']);
        $event->setSynopsis($data['synopsis']);
        $event->setActors($data['actors']);
        $event->setDirectors($data['directors']);

        $eventId = $event->save();

        // insert tag
        $tags = Helpers::splitFields($data['tags']);
        foreach ($tags as $tag) {
            $tagModel = new TagModel();
            $tagExists = $tagModel->findOne(
                [
                    'select' => 'label',
                    'where' => [
                        [
                            'column' => 'label',
                            'operator' => '=',
                            'value' => mb_strtoupper($tag)
                        ],
                    ]
                ]
            );

            if (!$tagExists) {
                $tagModel->setLabel(mb_strtoupper($tag));
                $tagModel->save();
            }
        }

        // jointure event - tag
        $eventTag = new EventTagModel();
        $eventTag->setEventId($eventId);

        foreach ($tags as $tag) {
            $eventTag->setTag(mb_strtoupper($tag));
            $eventTag->save();
        }

        // insert sessions
        $sessionsCount = count($data['date']);
        for ($i = 0; $i < $sessionsCount; $i++) {
            $sessionModel = new Event_room();
            $session = [
                'eventId' => $eventId,
                'startTime' => $data['date'][$i] . " " . $data['startTime'][$i],
                'endTime' => $data['date'][$i] . " " . $data['endTime'][$i],
                'room' => $data['room'][$i]
            ];

            $sessionModel->setEventId($session['eventId']);
            $sessionModel->setStartTime($session['startTime']);
            $sessionModel->setEndTime($session['endTime']);
            $sessionModel->setRoom($session['room']);

            $sessionModel->save();
        }

        Helpers::redirect('/admin/events');
    }

    public function updateEventAction()
    {
        $eventId = $_SESSION['edit_event_id'];
        $data = $_POST;

        /**
         *  update event 
         *  créer tags if not exists
         *  joiture event - tag if not exists
         *  joiture event - room if not exists
         */

        echo "<pre>";
        print_r($data);
        echo "</pre>";

        // update event
        $event = new EventModel();
        $event->setId($eventId);
        $event->setTitle($data['name']);
        $event->setSynopsis($data['synopsis']);
        $event->setActors($data['actors']);
        $event->setDirectors($data['directors']);

        $event->save();


        // insert tag if not exists
        $tags = Helpers::splitFields($data['tags']);
        foreach ($tags as $tag) {
            $tagModel = new TagModel();
            $tagExists = $tagModel->findOne(
                [
                    'select' => 'label',
                    'where' => [
                        [
                            'column' => 'label',
                            'operator' => '=',
                            'value' => mb_strtoupper($tag)
                        ],
                    ]
                ]
            );

            if (!$tagExists) {
                $tagModel->setLabel(mb_strtoupper($tag));
                $tagModel->save();
            }
        }


        // jointure event - tag
        $eventTag = new EventTagModel();

        $eventTag->deleteAll([
            'where' => [
                [
                    'column' => 'eventId',
                    'operator' => '=',
                    'value' => $eventId
                ],
            ]
        ]);

        $eventTag->setEventId($eventId);

        foreach ($tags as $tag) {
            $eventTag->setTag(mb_strtoupper($tag));
            $eventTag->save();
        }

        // insert sessions
        $sessionModel = new Event_room();

        $sessionModel->deleteAll([
            'where' => [
                [
                    'column' => 'eventId',
                    'operator' => '=',
                    'value' => $eventId
                ],
            ]
        ]);

        $sessionsCount = count($data['date']);
        for ($i = 0; $i < $sessionsCount; $i++) {
            $session = [
                'eventId' => $eventId,
                'startTime' => $data['date'][$i] . " " . $data['startTime'][$i],
                'endTime' => $data['date'][$i] . " " . $data['endTime'][$i],
                'room' => $data['room'][$i]
            ];

            $sessionModel->setEventId($session['eventId']);
            $sessionModel->setStartTime($session['startTime']);
            $sessionModel->setEndTime($session['endTime']);
            $sessionModel->setRoom($session['room']);

            $sessionModel->save();
        }

        Helpers::redirect('/admin/events');
    }
}
