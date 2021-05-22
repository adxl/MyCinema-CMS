<?php

namespace App\Controllers;

use App\Core\FormValidator;
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

        $users = array_filter($users, function ($v, $k) {
            return $v['isDeleted'] == false;
        }, ARRAY_FILTER_USE_BOTH);

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

    public function deleteUserAction()
    {
        $id = Helpers::getQueryParam('id');

        $userModel = new UserModel();
        $user = $userModel->findById($id);

        $userModel->populate($userModel, $user);

        $userModel->setIsDeleted(1);

        $userModel->save();

        Helpers::redirect('/bo/users');
    }

    public function showProfilAction()
    {

        $user = Security::getCurrentUser();
        $userModel = new UserModel();

        $view = new View("b_profile", 'back');

        $view->assign("title", 'Profil '.$user['firstname'] .' '. $user['lastname']);

        $form = $userModel->formBuilderProfilNames($user['firstname'], $user['lastname']);
        $view->assign('form', $form);




    }

    public function editProfilNamesAction()
    {
        $currentUser = Security::getCurrentUser();
        $id = $currentUser['id'];


        $userModel = new UserModel();
        $user = $userModel->findById($id);

        $userModel->populate($userModel, $user);

        $form = $userModel->formBuilderProfilNames($user['firstname'], $user['lastname']);


        if (!empty($_POST)) {

            $errors = FormValidator::check($form, $_POST);

            if (empty($errors)) {

                $userModel->setFirstname(htmlspecialchars($_POST["firstName"]));
                $userModel->setLastname(htmlspecialchars($_POST["lastName"]));

                $id = $userModel->save();

                if ($id) {
                    Helpers::redirect('/bo/profile');
                } else {
                    $errors = ["Un problème est survenu lors de l'inscription"];
                    setcookie("errorsForm", $errors);
                    Helpers::redirect('/bo/profile');
                }
            } else {
                $i = 0;
                foreach ($errors as $error)
                {
                    setcookie("errorsForm", $error, time()+3600);


                }

                Helpers::redirect('/bo/profile');
            }
        }



    }

}
