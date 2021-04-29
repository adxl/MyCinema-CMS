<?php

namespace App\Controllers;

use App\Core\View;
use App\Core\Database;

class MainController
{

    //Method : Action
    public function defaultAction()
    {
        // $pseudo = "Prof"; // Depuis la bdd


        // $sql = new Database();

        // echo DBHOST;

        //Affiche la vue home intégrée dans le template du front
        // $view = new View("home");
        // $view->assign("pseudo", $pseudo);
    }

    //Method : Action
    public function page404Action()
    {

        //Affiche la vue 404 intégrée dans le template du front
        // $view = new View("404");
    }
}
