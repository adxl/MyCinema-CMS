<?php

namespace App\Controllers;

use App\Core\FormValidator;
use App\Core\Helpers;
use App\Core\Security;
use App\Core\View;
use App\Core\Mailer;

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
                    Helpers::redirect("/bo");
                } else {
                    $view->assign("errors", ["Identifiants non valides"]);
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
            'select' => 'id, password, isActive',
            'where' => [
                [
                    'column' => 'email',
                    'operator' => '=',
                    'value' => htmlspecialchars($_POST['email'])
                ],
            ]
        ]);

        if (empty($user)) return null;
        if (!$user['isActive']) return null;
        if (!password_verify($_POST['password'], $user['password'])) return null;

        return $user;
    }

    public function registerAction()
    {
        $view = new View("b_register", 'back');
        $view->assign("title", 'Gestion des utilisateurs > Ajouter un collaborateur');

        $userModel = new UserModel();

        $form = $userModel->formBuilderRegister();

        if (!empty($_POST)) {

            $errors = FormValidator::check($form, $_POST);

            if (empty($errors)) {
                $validation = $this->validateRegister();

                if (empty($validation['errors'])) {
                    $id = $validation['user']->save();
                    if ($id) {
                        $mailObject = Mailer::init(
                            [
                                'address' => EMAIL_SMTP_ADMIN,
                                'name' => EMAIL_SOURCE_NAME
                            ],
                            [
                                [
                                    'address' => $validation['user']->getEmail(),
                                    'name' => $validation['user']->getFullName()
                                ]
                            ],
                            "Votre mot de passe",
                            "Votre compte a été créé, veuillez utilser le mot de passe suivant : <br><br>
                            <b>" . $validation['generatedPasswd'] . "</b><br><br>
                            Il est vivement conseillé de modifier votre mot de passe lors de votre première connexion.<br>
                            <small>Accédez à la section 'Compte' dans le menu déroulant en haut à droite</small>",
                            "MDP : " . $validation['generatedPasswd']
                        );

                        Mailer::sendEmail(
                            $mailObject,
                            function () {
                                Helpers::redirect('/bo/users');
                            },
                            function () use (&$view, &$userModel, &$id) {
                                $errors = ["L'envoi du mail a échoué. Le compte n'a pas été créé"];
                                $view->assign("errors", $errors);
                                $userModel->deleteById($id);
                            }
                        );
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
            $generatedPasswd = Helpers::generatePassword();
            $user->setFirstname(htmlspecialchars($_POST["firstName"]));
            $user->setLastname(htmlspecialchars($_POST["lastName"]));
            $user->setEmail(htmlspecialchars($_POST["email"]));
            $user->setPassword(password_hash($generatedPasswd, PASSWORD_DEFAULT));
        }

        return ['user' => $user, 'errors' => $errors, 'generatedPasswd' => $generatedPasswd ?? ''];
    }

    public function recoverPasswordAction()
    {
        $isAuthenticated = Security::isAuthenticated();
        if ($isAuthenticated) {
            Helpers::redirect();
        }

        $view = new View("f_password_recovery", "auth");
        $userModel = new UserModel();

        $form = $userModel->formBuilderRecoverPassword();

        if (!empty($_POST)) {

            $errors = FormValidator::check($form, $_POST);

            if (empty($errors)) {
                $view->assign('success', "Veuillez vérifier votre boîte mail");
                $this->handlePasswordRecovery($_POST["email"]);
                return;
            } else {
                $view->assign("errors", $errors);
            }
        }

        $view->assign('form', $form);
    }

    private function handlePasswordRecovery($email)
    {
        $userModel = new UserModel();
        $user = $userModel->findOne(
            [
                'where' => [
                    [
                        'column' => 'email',
                        'operator' => '=',
                        'value' => $email
                    ],
                ]
            ]
        );

        if ($user) {
            $newPassword = Helpers::generatePassword();
            $userModel->populate($userModel, $user);
            $userModel->setPassword(password_hash($newPassword, PASSWORD_DEFAULT));

            $userModel->save();

            $mailObject = Mailer::init(
                [
                    'address' => EMAIL_SMTP_ADMIN,
                    'name' => EMAIL_SOURCE_NAME
                ],
                [
                    [
                        'address' => $userModel->getEmail(),
                        'name' => $userModel->getFullName()
                    ]
                ],
                "Votre nouveau mot de passe",
                "Vous avez demandé le changement de votre mot de passe, veuillez utilser le votre nouveau mot de passe : <br><br>
                <b>" . $newPassword . "</b><br><br>",
                "Mot de passe : " . $newPassword
            );

            Mailer::sendEmail($mailObject);
        }
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
