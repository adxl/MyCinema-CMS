<?php

namespace App\Controllers;

use App\Core\View;

class CommentsController
{
    public function showCommentsAction()
    {
        $view = new View("comments", "back");
        $view->assign("title", 'Comments management');
    }
}
