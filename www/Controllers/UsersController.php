<?php

namespace App\Controllers;

use App\Core\View;
use App\Models\User as UserModel;

class UsersController
{
    public function showUsersAction()
    {
        $view = new View("b_users", 'back');
        $view->assign("title", 'Users management');

        $user = new UserModel();
    }
}
