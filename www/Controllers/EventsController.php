<?php

namespace App\Controllers;

use App\Core\FormValidator;
use App\Core\Helpers;
use App\Core\Sitemap;
use App\Core\View;
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
        $view->assign("title", 'Gestion des évènements');

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
    public function createEventAction()
    {
        $view = new View("b_events_create", "back");
        $view->assign("title", 'Gestion des évènements > Nouvel évènement');

        $eventModel = new EventModel();
        $form = $eventModel->formBuilderCreate();

        $view->assign('form', $form);

        if (!empty($_POST)) {

            $errors = FormValidator::checkEventForm($form, $_POST);

            if (empty($errors)) {

                $data = $_POST;
                $file = $_FILES['media'];

                // create base event
                $eventModel->setTitle($data['name']);
                $eventModel->setSynopsis($data['synopsis']);
                $eventModel->setActors($data['actors']);
                $eventModel->setDirectors($data['directors']);

                if (empty($_FILES['media']['name'])) {
                    $view->assign("errors", ["Vous n'avez pas ajouté d'image du film"]);
                    exit;
                }

                if ($_FILES['media']['size'] === 0) {
                    $view->assign("errors", ["La photo ne doit pas dépasser 2M"]);
                    exit;
                }

                $file_type = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                $media = "/Views/images/event_" .  Helpers::slugify($eventModel->getTitle()) . '.' . $file_type;

                if (!getimagesize($file["tmp_name"])) {
                    $view->assign("errors", ["L'image est invalide"]);
                    exit;
                }

                $allowed_types = ['jpg', 'jpeg', 'png'];
                if (!in_array($file_type, $allowed_types)) {
                    $view->assign("errors", ["Le format de l'image est invalide"]);
                    exit;
                }


                if (!move_uploaded_file($file["tmp_name"], '/var/www/html' . $media)) {
                    $view->assign("errors", ["La photo n'a pas pu être ajoutée"]);
                    exit;
                }

                $eventModel->setMedia($media);

                $eventId = $eventModel->save();

                // insert tags
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

                Sitemap::generate();

                Helpers::redirect('/bo/events');
            } else {
                $view->assign("errors", $errors);
            }
        }
    }

    public function editEventAction()
    {
        $id = Helpers::getQueryParam('id');

        if ($id) {
            $eventModel = new EventModel();
            $event = $eventModel->findById($id);

            if ($event) {

                $view = new View("b_events_edit", "back");
                $view->assign("title", 'Gestion des évènements > Modifier un évènement');

                $event['sessions'] = $eventModel->getSessions($id);
                $event['tags'] = Helpers::unsplitFields($eventModel->getTags($id));

                $form = $eventModel->formBuilderUpdate($event);
                $view->assign('form', $form);
                $view->assign('event_id', $id);

                if (!empty($_POST)) {

                    $errors = FormValidator::checkEventForm($form, $_POST);

                    if (empty($errors)) {

                        $data = $_POST;
                        $file = $_FILES['media'];

                        $eventModel->setId($id);
                        $eventModel->setTitle($data['name']);
                        $eventModel->setMedia($event['media']);
                        $eventModel->setSynopsis($data['synopsis']);
                        $eventModel->setActors($data['actors']);
                        $eventModel->setDirectors($data['directors']);


                        if (!empty($file['name'])) {

                            if (empty($_FILES['media']['name'])) {
                                $view->assign("errors", ["Vous n'avez pas ajouté d'image du film"]);
                                exit;
                            }

                            if ($_FILES['media']['size'] === 0) {
                                $view->assign("errors", ["La photo ne doit pas dépasser 2M"]);
                                exit;
                            }

                            $file_type = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                            $media = "/Views/images/event_" .  Helpers::slugify($eventModel->getTitle()) . '.' . $file_type;

                            if (!getimagesize($file["tmp_name"])) {
                                $view->assign("errors", ["L'image est invalide"]);
                                exit;
                            }

                            $allowed_types = ['jpg', 'jpeg', 'png'];
                            if (!in_array($file_type, $allowed_types)) {
                                $view->assign("errors", ["Le format de l'image est invalide"]);
                                exit;
                            }

                            if (!move_uploaded_file($file["tmp_name"], '/var/www/html' . $media)) {
                                $view->assign("errors", ["La photo n'a pas pu être ajoutée"]);
                                exit;
                            }

                            $eventModel->setMedia($media);
                        }

                        $eventModel->save();

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
                                    'value' => $id
                                ],
                            ]
                        ]);

                        $eventTag->setEventId($id);

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
                                    'value' => $id
                                ],
                            ]
                        ]);

                        $sessionsCount = count($data['date']);
                        for ($i = 0; $i < $sessionsCount; $i++) {
                            $session = [
                                'eventId' => $id,
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

                        Helpers::redirect('/bo/events');
                    } else {
                        $view->assign("errors", $errors);
                    }
                }
                return;
            }
        }
        $view = new View('b_404', 'front');
    }

    public function deleteEventAction()
    {
        $id = Helpers::getQueryParam('id');

        $event = new EventModel();
        $event->deleteById($id);

        Sitemap::generate();

        Helpers::redirect('/bo/events');
    }
}
