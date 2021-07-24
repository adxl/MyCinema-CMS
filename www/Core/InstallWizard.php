<?php

namespace App\Core;

use App\Core\EnvironmentManager as Env;
use App\Core\Security;

class InstallWizard
{

    public static function check(): bool
    {
        $fileName = ".env";
        if (!file_exists($fileName))
            return false;

        $file = fopen($fileName, 'r');
        $envPattern = "/([^=]*)=([^#]*)/";
        $envPairs = [];

        while (!feof($file)) {
            $line = fgets($file);
            preg_match($envPattern, $line, $results);
            if (!empty($results[1]) && !empty($results[2]))
                $envPairs[mb_strtoupper($results[1])] = trim($results[2]);
        }

        if (!isset($envPairs['WEBSITE_NAME']))
            return false;

        return true;
    }

    public static function start()
    {

        unset($_SESSION["authSession"]);

        $form = InstallWizard::formBuilderInstall();
        $view = "Views/views/install.view.php";

        if (!empty($_POST)) {
            $errors = InstallWizard::execute($_POST);
            if (empty($errors)) {
                InstallWizard::migrate();
            }
        }

        include "Views/templates/install.tpl.php";
    }

    private static function formBuilderInstall()
    {
        return  [
            "config" => [
                "method" => "POST",
                "action" => "#",
                "id" => "form_install",
                "submit" => "Enregister",
                "submitClass" => 'w-50'
            ],

            "inputs" => [
                "WEBSITE_NAME" => [
                    "type" => "text",
                    'class' => 'field w-100',
                    "label" => "Nom du site",
                    "hint" => "Le nom affiché sur le site web",
                    "value" => "ParisMovies.com"
                ],

                "WEBSITE_CONTACT_ADDRESS" => [
                    "type" => "email",
                    'class' => 'field w-100',
                    "label" => "Adresse de contact",
                    "hint" => "L'adresse email de contact",
                    "value" => "adelsenhadjii@gmail.com"
                ],

                "WEBSITE_ADMIN" => [
                    "type" => "text",
                    'class' => 'field w-100',
                    "label" => "Admin du site",
                    "hint" => "Choisissez un identifiant pour le super-admin",
                    "value" => "admin@mycinema.com"
                ],

                "WEBSITE_PASSWORD" => [
                    "type" => "password",
                    'class' => 'field w-100 mb-xl',
                    "label" => "Mot de passe du site",
                    "hint" => "Choisissez un mot de passe pour le super-admin",
                    "value" => "Password9$"
                ],

                "DB_HOST" => [
                    "type" => "text",
                    'class' => 'field w-100',
                    "label" => "Serveur",
                    "hint" => "Votre serveur de base de données",
                    "value" => "database"
                ],
                "DB_NAME" => [
                    "type" => "text",
                    'class' => 'field w-100',
                    "label" => "Nom",
                    "hint" => "Nom de la base de données",
                    "value" => "mycinema_db"
                ],
                "DB_USER" => [
                    "type" => "text",
                    'class' => 'field w-100',
                    "label" => "Utilisateur",
                    "hint" => "Nom de l'utilisateur de la base de données",
                    "value" => "mc_root"
                ],
                "DB_PASSWORD" => [
                    "type" => "password",
                    'class' => 'field w-100 mb-xl',
                    "label" => "Mot de passe",
                    "hint" => "Mot de passe de l'utilisateur ci-dessus",
                    "value" => "mc_password"
                ],
                "EMAIL_SOURCE_NAME" => [
                    "type" => "text",
                    'class' => 'field w-100',
                    "label" => "Nom SMTP",
                    "hint" => "Le nom affiché aux destinataires des emails",
                    "value" => "Support MyCinema"
                ],
                "EMAIL_SMTP_HOST" => [
                    "type" => "text",
                    'class' => 'field w-100',
                    "label" => "Serveur SMTP",
                    "hint" => "Votre serveur SMTP",
                    "value" => "ssl0.ovh.net"
                ],
                "EMAIL_SMTP_ADMIN" => [
                    "type" => "email",
                    'class' => 'field w-100',
                    "label" => "Adresse SMTP",
                    "hint" => "Votre adresse SMTP",
                    "value" => "admin@la11eme.fr"
                ],
                "EMAIL_SMTP_PASSWORD" => [
                    "type" => "password",
                    'class' => 'field w-100',
                    "label" => "Mot de passe SMTP",
                    "hint" => "Votre mot de passe SMTP",
                    "value" => "acdLLmap:94"
                ],
                "EMAIL_SMTP_PORT" => [
                    "type" => "text",
                    'class' => 'field w-100',
                    "label" => "Port SMTP",
                    "hint" => "Le port du serveur SMTP",
                    "value" => "587"
                ],
            ]
        ];
    }

    public static function execute($data)
    {
        $formConfig = InstallWizard::formBuilderInstall();
        $errors = FormValidator::checkWizard($formConfig, $data);

        if (!empty($errors)) {
            return $errors;
        }

        $defaultEnv = [
            'WEBSITE_NAME' => $data['WEBSITE_NAME'],
            'WEBSITE_CONTACT_ADDRESS' => $data['WEBSITE_CONTACT_ADDRESS'],
            'ENV' => 'prod'
        ];

        $databaseEnv = [
            'DB_HOST' => $data['DB_HOST'],
            'DB_DRIVER' => "mysql",
            'DB_PORT' => 3306,
            'DB_NAME' => $data['DB_NAME'],
            'DB_PREFIXE' => "faman_",
            'DB_USER' => $data['DB_USER'],
            'DB_PASSWORD' => $data['DB_PASSWORD']
        ];

        $mailingEnv = [
            "EMAIL_SOURCE_NAME" => $data['EMAIL_SOURCE_NAME'],
            "EMAIL_SMTP_HOST" => $data['EMAIL_SMTP_HOST'],
            "EMAIL_SMTP_ADMIN" => $data['EMAIL_SMTP_ADMIN'],
            "EMAIL_SMTP_PASSWORD" => $data['EMAIL_SMTP_PASSWORD'],
            "EMAIL_SMTP_PORT" => $data['EMAIL_SMTP_PORT']
        ];

        $defaultEnvFile = ".env";
        $databaseEnvFile =  ".env.db";
        $SMTPEnvFile =  ".env.smtp";

        Env::writeEnvData($defaultEnv, $defaultEnvFile);
        Env::writeEnvData($databaseEnv, $databaseEnvFile);
        Env::writeEnvData($mailingEnv, $SMTPEnvFile);

        $envFiles = [$defaultEnvFile, $databaseEnvFile, $SMTPEnvFile];
        foreach ($envFiles as $file) {
            if (!file_exists($file)) {
                die("Erreur ENV-W001");
            }
        }

        $_SESSION["WIZARD_ADMIN_CREDENTIALS"] = [
            'email' => $data["WEBSITE_ADMIN"],
            'password' => $data["WEBSITE_PASSWORD"],
        ];

        return [];
    }

    public static function migrate()
    {
        new ConstantManager();

        $database = new Database();
        $id = $database->migrate();

        Security::initSession($id);

        Helpers::redirect("/bo");
    }
}
