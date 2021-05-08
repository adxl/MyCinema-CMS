<?php

namespace App\Controllers;

use App\Core\View;

class SettingsController
{
    public function showSettingsAction()
    {
        $view = new View("b_settings", 'back');
        $view->assign("title", 'Settings');
    }
}
