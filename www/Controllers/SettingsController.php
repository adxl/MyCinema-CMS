<?php

namespace App\Controllers;

use App\Core\EnvironmentManager;
use App\Core\FormValidator;
use App\Core\Helpers;
use App\Core\View;

use App\Models\Settings;

class SettingsController
{
    public function showSettingsAction()
    {
        $view = new View("b_settings", 'back');
        $view->assign("title", 'Paramètres du CMS');

        $settings = new Settings();
        $databaseSettings = $settings->formBuilderDatabase();
        $mailingSettings = $settings->formBuilderMailing();

        $view->assign('formDatabase', $databaseSettings);
        $view->assign('formMailing', $mailingSettings);


        if (isset($_SESSION["SETTINGS_ALERT"])) {
            $alert = Helpers::getAlert();
            $view->assign($_SESSION["SETTINGS_ALERT"] . "_" . $alert["type"], $alert['messages']);
        }

        Helpers::emptyAlert();
        unset($_SESSION['SETTINGS_ALERT']);
    }

    public function saveDatabaseSettingsAction()
    {
        $data = $_POST;

        $settings = new Settings();
        $formConfig = $settings->formBuilderDatabase();

        $errors = FormValidator::checkDatabaseSettings($formConfig, $data);

        if (!empty($errors)) {
            Helpers::storeAlert($errors);
        } else {
            EnvironmentManager::updateDatabaseEnv($data);
            Helpers::storeAlert(["Modifications enregistrées avec succès"], true);
        }

        $_SESSION['SETTINGS_ALERT'] = 'db';
        Helpers::redirect("/bo/settings");
    }

    public function saveMailingSettingsAction()
    {
        $data = $_POST;

        $settings = new Settings();
        $formConfig = $settings->formBuilderMailing();

        $errors = FormValidator::checkMailingSettings($formConfig, $data);

        if (!empty($errors)) {
            Helpers::storeAlert($errors);
        } else {
            EnvironmentManager::updateMailingEnv($data);
            Helpers::storeAlert(["Modifications enregistrées avec succès"], true);
        }

        $_SESSION['SETTINGS_ALERT'] = 'smtp';
        Helpers::redirect("/bo/settings");
    }
}
