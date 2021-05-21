<?php

namespace App\Controllers;

use App\Core\FormValidator;
use App\Core\Helpers;
use App\Core\Security;
use App\Core\View;

use App\Models\User as UserModel;
use App\Models\Session as SessionModel;

class AuthenticationController
{
    public function loginAction()
    {
        $isAuthenticated = Security::isAuthenticated();
        if ($isAuthenticated) {
            Helpers::redirect();
        }

        $view = new View("f_login", "auth");
        $userModel = new UserModel();

        $form = $userModel->formBuilderLogin();

        if (!empty($_POST)) {

            $errors = FormValidator::check($form, $_POST);

            if (empty($errors)) {
                $user = $this->validateLogin();

                if (!is_null($user)) {
                    Security::initSession($user['id']);
                    Helpers::redirect();
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
                return $user;

        return null;
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
                    $id = $validation['user']->save();
                    if ($id) {
                        Helpers::redirect('/bo/users');
                    } else {
                        $errors = ["Un problème est survenu lors de l'inscription"];
                        $view->assign("errors", $errors);
                    }
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
            $user->setFirstname(htmlspecialchars($_POST["firstName"]));
            $user->setLastname(htmlspecialchars($_POST["lastName"]));
            $user->setEmail(htmlspecialchars($_POST["email"]));
            $user->setPwd(password_hash(htmlspecialchars($_POST["pwd"]), PASSWORD_DEFAULT));
        }

        return ['user' => $user, 'errors' => $errors];
    }

    public function logoutAction()
    {
        session_start();

        if (isset($_SESSION['authSession'])) {
            $session = $_SESSION['authSession'];
            unset($_SESSION['authSession']);

            $sessionModel = new SessionModel();
            $sessionModel->deleteById($session['id']);
        }

        Helpers::redirect('/bo/login');
    }
}
