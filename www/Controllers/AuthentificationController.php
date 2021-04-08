<?php


namespace App\Controllers;

use App\Core\View;


class AuthentificationController
{

    public function loginAction()
    {
        $view = new View("dashboard", "auth");
        $view->assign("title", 'Dashboard');
    }
}