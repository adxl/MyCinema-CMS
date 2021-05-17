<?php

namespace App\Controllers;

use App\Core\View;
use App\Core\Security;

class MainController
{

    public function showHomePageAction()
    {

        $user = Security::getCurrentUser();

        echo "<pre>";
        echo ($user['firstname'] . $user['lastname']);
        echo "</pre>";

        $view = new View("f_home", 'front');
        $view->assign("pseudo", 'USER');
    }

    public function page404Action()
    {
        $view = new View("f_404", 'front');
    }
}
