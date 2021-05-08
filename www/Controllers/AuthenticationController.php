<?php

namespace App\Controllers;

use App\Core\View;

class AuthenticationController
{
    public function loginAction()
    {
        $view = new View("f_login", "auth");
    }
}
