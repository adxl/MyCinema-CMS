<?php

namespace App\Controllers;

use App\Core\View;

class HomeController
{
    public function showDashboardAction()
    {
        $view = new View("b_dashboard", 'back');
        $view->assign("title", 'Dashboard');
    }


}
