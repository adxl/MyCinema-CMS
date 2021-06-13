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

        $tab = Helpers::getQueryParam('tab') ?? 'general';

        $settings = new Settings();
        switch ($tab) {
            case 'general':
                $form = $settings->formBuilderGeneral();
                break;
            case 'database':
                $form = $settings->formBuilderDatabase();
                break;
            case 'mailing':
                $form = $settings->formBuilderMailing();
                break;
            default:
                Helpers::redirect('/500');
                die();
        }

        $view->assign('form', $form);

        $alert = Helpers::getAlert();
        if ($alert) {
            $view->assign($alert["type"], $alert['messages']);
        }

        Helpers::emptyAlert();
    }

    public function saveGeneralSettingsAction()
    {
        $data = $_POST;

        $settings = new Settings();
        $formConfig = $settings->formBuilderGeneral();

        $errors = FormValidator::check($formConfig, $data);

        if (!empty($errors)) {
            Helpers::storeAlert($errors);
        } else {
            EnvironmentManager::updateGeneralEnv($data);
            Helpers::storeAlert(["Modifications enregistrées avec succès"], true);
        }

        Helpers::redirect("/bo/settings?tab=general");
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

        Helpers::redirect("/bo/settings?tab=database");
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

        Helpers::redirect("/bo/settings?tab=mailing");
    }
}
