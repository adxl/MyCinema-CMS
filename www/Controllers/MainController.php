<?php

namespace App\Controllers;

use App\Core\View;
use App\Core\Database;

class MainController
{

    //Method : Action
    public function showHomePageAction()
    {
        $view = new View("f_home", 'front');
        $view->assign("pseudo", 'USER');
    }

    //Method : Action
    public function page404Action()
    {
        $view = new View("f_404", 'front');
    }
}
