<?php

namespace App\Controllers;

use App\Core\FormValidator;

use App\Core\Helpers;
use App\Core\Security;
use App\Core\View;
use App\Models\User as UserModel;

class AccountController
{

    public function showAccountAction()
    {
        $user = Security::getCurrentUser();

        $view = new View("b_account", 'back');
        $view->assign("title", 'Profil de ' . $user['firstname'] . ' ' . $user['lastname']);

        $userModel = new UserModel();

        $formNames = $userModel->formBuilderAccountNames($user);
        $view->assign('formNames', $formNames);

        $formEmail = $userModel->formBuiderAccountEmail($user);
        $view->assign('formEmail', $formEmail);

        $formPassword = $userModel->formBuilderAccountPassword();
        $view->assign('formPassword', $formPassword);

        $alert = Helpers::getAlert();
        if ($alert)
            $view->assign($alert['type'], $alert['messages']);

        Helpers::emptyAlert();
    }

    public function editAccountNamesAction()
    {
        $currentUser = Security::getCurrentUser();
        $id = $currentUser['id'];

        $userModel = new UserModel();
        $user = $userModel->findById($id);

        $userModel->populate($userModel, $user);

        $form = $userModel->formBuilderAccountNames($user);

        if (!empty($_POST)) {
            $data = Helpers::cleanInputs($_POST);
            $errors = FormValidator::check($form, $data);

            if (empty($errors)) {
                $userModel->setFirstname(htmlspecialchars($data["firstName"]));
                $userModel->setLastname(htmlspecialchars($data["lastName"]));

                $id = $userModel->save();

                if ($id)
                    Helpers::storeAlert(['Vos modifications ont bien été enregistré'], true);
                else
                    Helpers::storeAlert(['Un problème est survenu lors de la modification des données']);
            } else
                Helpers::storeAlert($errors);

            Helpers::redirect('/bo/account');
        }
    }

    public function editAccountEmailAction()
    {
        $currentUser = Security::getCurrentUser();
        $id = $currentUser['id'];

        $userModel = new UserModel();
        $user = $userModel->findById($id);

        $userModel->populate($userModel, $user);

        $form = $userModel->formBuiderAccountEmail($user['email']);

        if (!empty($_POST)) {
            $data = Helpers::cleanInputs($_POST);
            $errors = FormValidator::check($form, $data);

            if (empty($errors)) {

                $emailVerif = $userModel->verifUniqEmail($data["email"]);

                if ($emailVerif) {
                    $userModel->setEmail($data["email"]);

                    $id = $userModel->save();

                    if ($id)
                        Helpers::storeAlert(['Vos modifications ont bien été enregistré'], true);
                    else
                        Helpers::storeAlert(['Un problème est survenu lors de la modification des données']);
                } else {
                    Helpers::storeAlert(['Email already used']);
                }
            } else
                Helpers::storeAlert($errors);

            Helpers::redirect('/bo/account');
        }
    }

    public function editAccountPasswordAction()
    {
        $currentUser = Security::getCurrentUser();
        $id = $currentUser['id'];

        $userModel = new UserModel();
        $user = $userModel->findById($id);

        $userModel->populate($userModel, $user);

        $form = $userModel->formBuilderAccountPassword();

        if (!empty($_POST)) {
            $data = Helpers::cleanInputs($_POST);
            $errors = FormValidator::check($form, $data);

            if (empty($errors)) {
                if (password_verify($data['actualPwd'], $user['password'])) {
                    $userModel->setPassword(password_hash($data["pwd"], PASSWORD_DEFAULT));

                    $id = $userModel->save();

                    if ($id)
                        Helpers::storeAlert(["Votre mot de passe a bien été enregistré"], true);
                    else
                        Helpers::storeAlert(["Un problème est survenu lors de la modification du mot de passe"]);
                } else
                    Helpers::storeAlert(["Veuillez renseignez le bon mot de passe actuel"]);
            } else
                Helpers::storeAlert($errors);

            Helpers::redirect('/bo/account');
        }
    }
}
