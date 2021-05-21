<?php

namespace App\Controllers;

use App\Core\View;
use App\Models\User as UserModel;

class UsersController
{
    public function showUsersAction()
    {
        $view = new View("b_users", 'back');
        $view->assign("title", 'Gestion des utilisateurs');

        $userModel = new UserModel();
        $users = $userModel->findAll();

        foreach ($users as $key => $user) {
            unset($user['password']);
            $users[$key] = $user;
        }

        $view->assign("users", $users);
    }
}
