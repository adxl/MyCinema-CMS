<?php

namespace App\Controllers;

use App\Core\View;
use App\Core\Security;

class MainController
{

    public function showHomePageAction()
    {
        $view = new View("f_home", 'front');
    }

    public function page404Action()
    {
        $view = new View("f_404", 'front');
    }
}
