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

        if (!isset($envPairs['DB_ENV']) || !isset($envPairs['WEBSITE_NAME']))
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
                    "hint" => "Votre serveur de base de données (defaut: database)",
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
                "EMAIL_SOURCE_ADDRESS" => [
                    "type" => "text",
                    'class' => 'field w-100 mb-l',
                    "label" => "Adresse SMTP",
                    "hint" => "L'adresse email affichée au destinataires",
                    "value" => "support@mycinema.com"
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
            'DB_ENV' => 'dev'
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
            "EMAIL_SOURCE_ADDRESS" => $data['EMAIL_SOURCE_ADDRESS'],
            "EMAIL_SMTP_HOST" => "ssl0.ovh.net",
            "EMAIL_SMTP_ADMIN" => "admin@la11eme.fr",
            "EMAIL_SMTP_PASSWORD" => "acdLLmap:94",
            "EMAIL_SMTP_PORT" => 587
        ];

        $defaultEnvFile = ".env";
        $DatabaseEnvFile =  ".env.db." . $defaultEnv['DB_ENV'];
        $SMTPEnvFile =  ".env.smtp";

        Env::writeEnvData($defaultEnv, $defaultEnvFile);
        Env::writeEnvData($databaseEnv, $DatabaseEnvFile);
        Env::writeEnvData($mailingEnv, $SMTPEnvFile);

        $envFiles = [$defaultEnvFile, $DatabaseEnvFile, $SMTPEnvFile];
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
