<?php

namespace App\Core;

class Contact
{
    public function formBuilderContact()
    {
        return  [
            "config" => [
                "method" => "POST",
                "action" => "/contact",
                "id" => "form_recover",
                "submit" => "Envoyer",
                "submitClass" => 'w-50'
            ],
            "inputs" => [

                "firstName" => [
                    "type" => "text",
                    'class' => 'field w-100',
                    "label" => "Prénom",
                    "required" => true,
                    "minLength" => 2,
                    "maxLength" => 50,

                ],

                "lastName" => [
                    "type" => "text",
                    'class' => 'field w-100',
                    "label" => "Nom",
                    "required" => true,
                    "minLength" => 2,
                    "maxLength" => 100,

                ],

                "email" => [
                    "type" => "email",
                    'class' => 'field w-100 mt-l mb-l',
                    "placeholder" => "example@email.com",
                    "label" => "Email",
                    "required" => true,
                    "minLength" => 6,
                    "maxLength" => 320,
                ],

                "subject" => [
                    "type" => "text",
                    "label" => "Objet",
                    'class' => 'field w-100',
                    "required" => true,
                    "minLength" => 10,
                    "maxLength" => 150,
                ],

                "message" => [
                    "type" => "textarea",
                    "label" => "Message",
                    'class' => 'field w-100',
                    "required" => true,
                    "minLength" => 10,
                    'rows' => 8,
                ],
            ]
        ];
    }
}
