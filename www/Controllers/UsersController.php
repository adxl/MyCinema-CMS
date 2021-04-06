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
        // $view = new View("users");
        // $view->assign("title", 'Users management');

        $user = new UserModel();
        $user->save();
    }


    //Method : Action
    public function registerAction()
    {

        // $user = new UserModel();
        // die("he");
        /*
			$user->setFirstname("Yves");
			$user->setLastname("SKRZYPCZYK");
			$user->setEmail("y.skrzypczyk@gmail.com");
			$user->setPwd("Test1234");
			$user->setCountry("fr");

			$user->save();



			$page = new Page();
			$page->setTitle("Nous contacter");
			$page->setSlug("/contact");
			$page->save();



			$user = new User();
			$user->setId(2); //Attention on doit populate
			$user->setFirstname("Toto");
			$user->save();

		*/


        // $view = new View("register");

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
