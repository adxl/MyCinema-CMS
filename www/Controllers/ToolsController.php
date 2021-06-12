<?php

namespace App\Controllers;

use App\Core\Sitemap;
use App\Core\View;

class ToolsController
{
    public function showToolsAction()
    {
        $view = new View('b_tools', 'back');
        $view->assign("title", 'Utilitaires');
    }

    public function generateSitemapAction()
    {
        Sitemap::generate();
    }
}
