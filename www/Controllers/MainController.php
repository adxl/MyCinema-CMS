<?php

namespace App\Controllers;

use App\Core\Contact;
use App\Core\FormValidator;
use App\Core\Mailer;
use App\Core\View;
use App\Core\Helpers;

use App\Models\Comment;
use App\Models\Event;
use App\Models\Room;
use App\Models\Website;

class MainController
{

    public function showHomePageAction()
    {
        $view = new View("f_home", 'front');

        $roomModel = new Room();
        $rooms = $roomModel->findAll();
        shuffle($rooms);
        $rooms = array_slice($rooms, 0, 3);

        $eventModel = new Event();

        $allEvents = $eventModel->getIncomingEvents();

        $eventsIds = [];
        $events = [];
        foreach ($allEvents as $event) {
            $id = $event['id'];
            if (!in_array($id, $eventsIds)) {
                $eventsIds[] = $id;
                $events[] = $event;
            }
        }

        shuffle($events);
        $events = array_slice($events, 0, 3);

        foreach ($events as $key => $event) {
            $eventId = $event['id'];
            $events[$key]['nextSession'] = $eventModel->getNextSessionDate($eventId);
        }

        $view->assign('events', $events);
        $view->assign('rooms', $rooms);
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
        if ($nextEvent) {
            $nextEvent['actors'] = str_replace(';', ',', $nextEvent['actors']);
        }

        // get incoming events
        $allIncomingEvents = $eventModel->getIncomingEvents();

        // remove duplicates
        $incomingEventsIds = [];
        if ($nextEvent) {
            $incomingEventsIds[] = $nextEvent['id'];
        }

        $incomingEvents = [];
        foreach ($allIncomingEvents as $event) {
            $id = $event['id'];
            if (!in_array($id, $incomingEventsIds)) {
                $incomingEventsIds[] = $id;
                $incomingEvents[] = $event;
            }
        }

        shuffle($incomingEvents);
        $incomingEvents = array_slice($incomingEvents, 0, 8);

        foreach ($incomingEvents as $key => $event) {
            $eventId = $event['id'];
            $incomingEvents[$key]['nextSession'] = $eventModel->getNextSessionDate($eventId);
        }

        $view->assign('nextEvent', $nextEvent);
        $view->assign('incomingEvents', $incomingEvents);
    }

    public function showOneEventAction($id)
    {
        $view = new View("f_event", 'front');

        $eventModel = new Event();
        $event = $eventModel->findById($id);

        if (!$event) {
            Helpers::redirect('404');
        }

        $event['tags'] = $eventModel->getTags($event['id']);

        $allSessions = $eventModel->getSessions($id);
        $eventSessions = ['total' => count($allSessions), 'items' => []];

        foreach ($allSessions as $session) {
            $sessionDate = $session['date'];
            $startTime = $session['startTime'];
            $endTime = $session['endTime'];

            $roomId = $session['roomId'];
            $room = $session['room'];

            if (isset($eventSessions['items'][$sessionDate])) {
                $eventSessions['items'][$sessionDate][] = ['startTime' => $startTime, 'endTime' => $endTime, 'room' => ['id' => $roomId, 'name' => $room]];
                continue;
            }

            $eventSessions['items'][$sessionDate] = [['startTime' => $startTime, 'endTime' => $endTime, 'room' => ['id' => $roomId, 'name' => $room]]];
        }

        $event['sessions'] = $eventSessions;

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
            ],
            'order' => [
                'column' => 'createdAt',
                'order' => 'DESC'
            ]
        ]);

        $view->assign('event', $event);
        $view->assign('commentForm', $commentForm);
        $view->assign('comments', $comments);

        if (!empty($_POST)) {
            $data = Helpers::cleanInputs($_POST);
            $errors = FormValidator::check($commentForm, $data);

            if (!empty($errors)) {
                $view->assign('errors', $errors);
            } else {
                $commentModel->setName($data['name']);
                $commentModel->setContent($data['content']);
                $commentModel->setEventId($id);

                $commentModel->save();

                $view->assign('success', "Votre commentaire est en attente de validation");
            }
        }
    }

    public function showRoomsAction()
    {
        $view = new View("f_rooms", 'front');

        $roomModel = new Room();
        $rooms = $roomModel->findAll();

        $view->assign('rooms', $rooms);

        if ($rooms) {
            $cover_room_key = array_rand($rooms);
            $cover_room = $rooms[$cover_room_key];

            unset($rooms[$cover_room_key]);

            $view->assign('cover_room', $cover_room);
        }
    }

    public function showContactAction()
    {
        $view = new View("f_contact", 'front');

        $contact = new Contact();

        $form = $contact->formBuilderContact();

        if (!empty($_POST)) {
            $data = Helpers::cleanInputs($_POST);
            $errors = FormValidator::check($form, $data);
            if (empty($errors)) {

                $emailBody = "<div>
                                <p>Prénom : " . $data["firstName"] . " </p>
                                <p>Nom : " . $data["lastName"] . " </p>
                                <br>
                                <p>Email : " . $data["email"] . " </p>
                                <br>
                                <p>Object : " . $data["subject"] . " </p>
                                <p>Message : " . $data["message"] . " </p>
                            </div>";

                $mailObject = Mailer::init(
                    [
                        'address' => EMAIL_SMTP_ADMIN,
                        'name' => EMAIL_SOURCE_NAME
                    ],
                    [
                        [

                            'address' => WEBSITE_CONTACT_ADDRESS,
                        ]
                    ],
                    "[CONTACT] " . $data["subject"],
                    $emailBody
                );

                Mailer::sendEmail(
                    $mailObject,
                    function () use (&$view) {
                        $view->assign("success", "Votre message a été envoyé");
                    },
                    function () use (&$view) {
                        $errors = ["L'envoi du mail a échoué."];
                        $view->assign("errors", $errors);
                    }
                );
            } else {
                $view->assign("errors", $errors);
            }
        }


        $view->assign('form', $form);
    }

    public function showAboutAction()
    {
        $websiteModel = new Website();
        $website = $websiteModel->findAll()[0];

        $view = new View("f_about", 'front');
        $view->assign('about', $website['about']);
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
