<?php

namespace App\Controllers;

use App\Core\View;

class CommentsController
{
    public function showCommentsAction()
    {
        $view = new View("b_comments", "back");
        $view->assign("title", 'Gestion des commentaires');
    }
}
