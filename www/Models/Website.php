<?php

namespace App\Models;

use App\Core\Database;

class Website extends Database
{
    private $id;
    protected $about;

    public function __construct()
    {
        parent::__construct();
    }

    public function getId()
    {
        return 9;
    }

    public function getAbout()
    {
        return $this->about;
    }
    public function setAbout($about)
    {
        $this->about = $about;
    }

    private function getCurrentAboutValue()
    {
        $website = $this->findById($this->getId());
        return $website['about'];
    }

    public function formBuilderWebsite()
    {
        return  [
            "config" => [
                "method" => "POST",
                "action" => "/bo/settings/website",
                "id" => "form_settings_website",
                "submit" => "Enregister",
                "submitClass" => 'w-100 w-25@m'
            ],

            "inputs" => [
                "about" => [
                    "type" => "textarea",
                    'class' => 'field w-100',
                    "label" => "À propos",
                    "required" => false,
                    'rows' => 10,
                    "value" => $this->getCurrentAboutValue()
                ],
            ]
        ];
    }
}
