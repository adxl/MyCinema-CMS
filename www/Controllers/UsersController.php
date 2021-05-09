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

        $user->setFirstname("Adel");
        $user->setLastname("sen");
        $user->setEmail("adelsen@gmail.com");
        $user->setPwd("pass");
        $user->setAddress("5 rue victor schoelscher");
        $user->setCity("paris");
        $user->setZipCode("93100");
        $user->setBirthdate("1999-04-03");

        $user->save();
    }
}
