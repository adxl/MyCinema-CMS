<?php

namespace App\Controllers;

use App\Core\View;
use App\Core\FormValidator;
use App\Models\User as UserModel;

class AuthenticationController
{
    public function loginAction()
    {
        $view = new View("f_login", "auth");
        $user = new UserModel();

        $form = $user->formBuilderLogin();

        if (!empty($_POST)) {

            $errors = FormValidator::check($form, $_POST);

            if (empty($errors)) {
                $validation = $this->validateLogin();

                if ($validation) {
                    echo 'OKK connecté !'; //TODO: user est bon, ajouter session
                } else {
                    $view->assign("errors", ["Wrong email or password !"]);
                }
            } else {
                $view->assign("errors", $errors);
            }
        }

        $view->assign('form', $form);
    }

    public function validateLogin()
    {
        $userModel = new UserModel();

        $user = $userModel->findOne([
            'select' => 'id, password',
            'where' => [
                [
                    'column' => 'email',
                    'operator' => '=',
                    'value' => htmlspecialchars($_POST['email'])
                ],
            ]
        ]);

        if (!empty($user))
            if (password_verify($_POST['password'], $user['password']))
                return true;

        return false;
    }

    public function registerAction()
    {
        $view = new View("f_register", 'auth');
        $userModel = new UserModel();

        $form = $userModel->formBuilderRegister();

        if (!empty($_POST)) {

            $errors = FormValidator::check($form, $_POST);

            if (empty($errors)) {
                $validation = $this->validateRegister();

                if (empty($validation['errors'])) {
                    $validation['user']->save();
                } else {
                    $view->assign("errors", $validation['errors']);
                }
            } else {
                $view->assign("errors", $errors);
            }
        }

        $view->assign('form', $form);
    }

    public function validateRegister()
    {
        $user = new UserModel();
        $errors = [];

        // validate unique email
        $emailUsed = $user->findOne(
            [
                'select' => 'COUNT(*) as count',
                'where' => [
                    [
                        'column' => 'email',
                        'operator' => '=',
                        'value' => $_POST["email"]
                    ],
                ]
            ]
        );

        if ($emailUsed['count'] > 0) {
            $errors[] = "Email already used";
        } else {
            $user->setFirstname(htmlspecialchars($_POST["first-name"]));
            $user->setLastname(htmlspecialchars($_POST["last-name"]));
            $user->setEmail(htmlspecialchars($_POST["email"]));
            $user->setPwd(password_hash(htmlspecialchars($_POST["pwd"]), PASSWORD_DEFAULT));
        }

        return ['user' => $user, 'errors' => $errors];
    }
}
