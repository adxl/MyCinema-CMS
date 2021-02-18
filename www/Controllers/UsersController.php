<?php

namespace App\Controllers;

use App\Core\View;

class UsersController
{

    public function showUsersAction()
    {
        $view = new View("users");
    }
}
