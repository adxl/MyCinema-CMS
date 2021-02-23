<?php

namespace App\Controllers;

use App\Core\View;

class EventsController
{

    public function createEventAction()
    {
        $view = new View("events_create");
        $view->assign("title", 'Events management > Create');
    }
}
