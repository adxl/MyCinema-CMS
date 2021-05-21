<?php

namespace App\Controllers;

use App\Core\Helpers;
use App\Core\Security;
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

        $self = Security::getCurrentUserShort();

        $view->assign("users", $users);
        $view->assign("self", $self);
    }

    public function updateStatusAction()
    {
        $id = Helpers::getQueryParam('id');
        $status = Helpers::getQueryParam('status');

        $userModel = new UserModel();
        $user = $userModel->findById($id);

        $userModel->populate($userModel, $user);

        $userModel->setIsActive($status);

        $userModel->save();

        Helpers::redirect('/bo/users');
    }

    public function switchRoleAction()
    {
        $id = Helpers::getQueryParam('id');

        $userModel = new UserModel();
        $user = $userModel->findById($id);

        $userModel->populate($userModel, $user);

        $role = $user['role'] === 'ADMIN' ? 'MANAGER' : 'ADMIN';

        $userModel->setRole($role);

        $userModel->save();

        Helpers::redirect('/bo/users');
    }
}
