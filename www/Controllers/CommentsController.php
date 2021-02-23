<?php

namespace App\Controllers;

use App\Core\View;

class CommentsController
{

    public function showCommentsAction()
    {
        $view = new View("comments");
        $view->assign("title", 'Comments management');
    }
}
