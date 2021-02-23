<?php

namespace App\Controllers;

use App\Core\View;

class RoomsController
{

    public function showRoomsAction()
    {
        $view = new View("rooms");
        $view->assign("title", 'Rooms Management');
    }
}
