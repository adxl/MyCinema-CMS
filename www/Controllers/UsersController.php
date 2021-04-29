<?php

namespace App\Controllers;

use App\Core\View;
use App\Core\FormValidator;
use App\Models\User as UserModel;
use App\Models\Page;

class UsersController
{
    public function showUsersAction()
    {
        $view = new View("users", 'back');
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


    //Method : Action
    public function registerAction()
    {
        $view = new View("register");

        // $form = $user->formBuilderRegister();

                // if (!empty($_POST)) {

                //     $errors = FormValidator::check($form, $_POST);

                //     if (empty($errors)) {
                //         $user->setFirstname($_POST["firstname"]);
                //         $user->setLastname($_POST["lastname"]);
                //         $user->setEmail($_POST["email"]);
                //         $user->setPwd($_POST["pwd"]);
                //         $user->setCountry($_POST["country"]);

                //         $user->save();
                //     } else {
                //         $view->assign("errors", $errors);
                //     }
                // }

                // $view->assign("form", $form);
                // $view->assign("formLogin", $user->formBuilderLogin());
    }
}
