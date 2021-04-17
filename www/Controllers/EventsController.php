<?php

namespace App\Controllers;

use App\Core\View;

class EventsController
{
    public function showEventsAction()
    {
        $view = new View("events");
        $view->assign("title", 'Events management');
    }

    public function showCreateEventAction()
    {
        $view = new View("events_create");
        $view->assign("title", 'Events management > Create');
    }
}
