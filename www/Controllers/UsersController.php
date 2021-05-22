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

        $formNames = $userModel->formBuilderProfilNames($user['firstname'], $user['lastname']);
        $view->assign('formNames', $formNames);


        $formEmail = $userModel->formBuiderProfilEmail($user['email']);
        $view->assign('formEmail', $formEmail);

        $formPassword = $userModel->formBuilderProfilPassword();
        $view->assign('formPassword', $formPassword);

        if (isset($_SESSION['flash']))
        {
            switch (true)
            {
                case array_key_exists('error', $_SESSION['flash']):
                    $errors = $_SESSION['flash']['error'];
                    unset($_SESSION['flash']['error']);
                    $view->assign('errors', $errors);
                    break;
                case array_key_exists('success', $_SESSION['flash']):
                    $success = $_SESSION['flash']['success'];
                    unset($_SESSION['flash']['success']);
                    $view->assign('success', $success);
                    break;
            }

        }




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
                    $success = ['Vos modifications ont bien été enregistré'];
                    Helpers::addFlash('success', $success);
                    Helpers::redirect('/bo/profile');
                } else {
                    $errors = ["Un problème est survenu lors de la modification des données'"];
                    Helpers::addFlash('error', $errors);
                    Helpers::redirect('/bo/profile');
                }
            } else {
                Helpers::addFlash('error', $errors);
                Helpers::redirect('/bo/profile');
            }
        }



    }

    public function editProfilEmailAction()
    {
        $currentUser = Security::getCurrentUser();
        $id = $currentUser['id'];


        $userModel = new UserModel();
        $user = $userModel->findById($id);

        $userModel->populate($userModel, $user);

        $form = $userModel->formBuiderProfilEmail($user['email']);

        if (!empty($_POST)) {

            $errors = FormValidator::check($form, $_POST);

            if (empty($errors)) {

                $userModel->setEmail(htmlspecialchars($_POST["email"]));

                $id = $userModel->save();

                if ($id) {
                    $success = ['Vos modifications ont bien été enregistré'];
                    Helpers::addFlash('success', $success);
                    Helpers::redirect('/bo/profile');
                } else {
                    $errors = ["Un problème est survenu lors de la modification des données'"];
                    Helpers::addFlash('error', $errors);
                    Helpers::redirect('/bo/profile');
                }
            } else {
                Helpers::addFlash('error', $errors);
                Helpers::redirect('/bo/profile');
            }
        }
    }

    public function editProfilPasswordAction()
    {
        $currentUser = Security::getCurrentUser();
        $id = $currentUser['id'];


        $userModel = new UserModel();
        $user = $userModel->findById($id);

        $userModel->populate($userModel, $user);

        $form = $userModel->formBuilderProfilPassword();


        if (!empty($_POST)) {

            $errors = FormValidator::check($form, $_POST);

            if (empty($errors)) {
                if (password_verify($_POST['actualPwd'], $user['password']))
                {
                    $userModel->setPassword(password_hash(htmlspecialchars($_POST["pwd"]), PASSWORD_DEFAULT));

                    $id = $userModel->save();

                    if ($id) {
                        $success = ['Votre mot de passe a bien été enregistré'];
                        Helpers::addFlash('success', $success);
                        Helpers::redirect('/bo/profile');
                    } else {
                        $errors = ["Un problème est survenu lors de la modification du mot de passe"];
                        Helpers::addFlash('error', $errors);
                        Helpers::redirect('/bo/profile');
                    }
                }
                else {
                    $errors = ["Veuillez renseignez le bon mot de passe actuel"];
                    Helpers::addFlash('error', $errors);
                    Helpers::redirect('/bo/profile');
                }
            } else {
                Helpers::addFlash('error', $errors);
                Helpers::redirect('/bo/profile');
            }
        }
    }

}
