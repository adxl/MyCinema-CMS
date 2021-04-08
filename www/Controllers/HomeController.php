<?php

namespace App\Controllers;

use App\Core\View;

class HomeController
{

    public function showDashboardAction()
    {
        $view = new View("dashboard");
        $view->assign("title", 'Dashboard');
    }


}
