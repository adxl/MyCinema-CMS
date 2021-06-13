<?php

namespace App\Controllers;

use App\Core\Database;
use App\Core\Helpers;
use App\Core\Sitemap;
use App\Core\View;

class ToolsController
{
    public function showToolsAction()
    {
        $view = new View('b_tools', 'back');
        $view->assign("title", 'Utilitaires');

        $alert = Helpers::getAlert();
        if ($alert) {
            $view->assign($alert["type"], $alert["messages"]);
        }

        Helpers::emptyAlert();
    }

    public function generateSitemapAction()
    {
        Sitemap::generate();
    }

    public function testDatabaseConnectionAction()
    {
        if (Database::testConnection())
            Helpers::storeAlert(["Connexion à la base de données établie avec succès"], true);
        else
            Helpers::storeAlert(["Echec de la connexion à la base de données"]);

        Helpers::redirect('/bo/tools');
    }
}
