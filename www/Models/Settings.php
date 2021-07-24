<?php

namespace App\Models;

class Settings
{

    public function formBuilderGeneral()
    {
        return  [
            "config" => [
                "method" => "POST",
                "action" => "/bo/settings/general",
                "id" => "form_settings_general",
                "submit" => "Enregister",
                "submitClass" => 'w-50'
            ],

            "inputs" => [
                "WEBSITE_NAME" => [
                    "type" => "text",
                    'class' => 'field w-100',
                    "label" => "Nom du site",
                    "required" => true,
                    "hint" => "Le nom affiché sur le site web",
                    "value" => WEBSITE_NAME,
                ],
            ]
        ];
    }

    public function formBuilderDatabase()
    {
        return  [
            "config" => [
                "method" => "POST",
                "action" => "/bo/settings/database",
                "id" => "form_settings_database",
                "submit" => "Enregister",
                "submitClass" => 'w-50'
            ],

            "inputs" => [
                "DB_HOST" => [
                    "type" => "text",
                    'class' => 'field w-100',
                    "label" => "Serveur",
                    "hint" => "Votre serveur de base de données",
                    "value" => DB_HOST,
                ],
                "DB_NAME" => [
                    "type" => "text",
                    'class' => 'field w-100',
                    "label" => "Nom",
                    "hint" => "Nom de la base de données",
                    "value" => DB_NAME,
                ],
                "DB_USER" => [
                    "type" => "text",
                    'class' => 'field w-100',
                    "label" => "Utilisateur",
                    "hint" => "Nom d'utilisateur de la base de données",
                    "value" => DB_USER,
                ],
                "DB_PASSWORD" => [
                    "type" => "password",
                    'class' => 'field w-100',
                    "label" => "Mot de passe",
                    "hint" => "Mot de passe de l'utilisateur ci dessus",
                    "value" => DB_PASSWORD,
                ],
            ]
        ];
    }

    public function formBuilderMailing()
    {
        return  [
            "config" => [
                "method" => "POST",
                "action" => "/bo/settings/mailing",
                "id" => "form_settings_mailing",
                "submit" => "Enregister",
                "submitClass" => 'w-50'
            ],

            "inputs" => [
                "EMAIL_SOURCE_NAME" => [
                    "type" => "text",
                    'class' => 'field w-100',
                    "label" => "Nom",
                    "hint" => "Le nom affiché au destinataire du mail",
                    "value" => EMAIL_SOURCE_NAME,
                ],
                "EMAIL_SMTP_HOST" => [
                    "type" => "text",
                    'class' => 'field w-100',
                    "label" => "Serveur SMTP",
                    "hint" => "Votre serveur SMTP",
                    "value" => EMAIL_SMTP_HOST
                ],
                "EMAIL_SMTP_ADMIN" => [
                    "type" => "email",
                    'class' => 'field w-100',
                    "label" => "Adresse SMTP",
                    "hint" => "Votre adresse SMTP",
                    "value" => EMAIL_SMTP_ADMIN
                ],
                "EMAIL_SMTP_PASSWORD" => [
                    "type" => "password",
                    'class' => 'field w-100',
                    "label" => "Mot de passe SMTP",
                    "hint" => "Votre mot de passe SMTP",
                    "value" => EMAIL_SMTP_PASSWORD
                ],
                "EMAIL_SMTP_PORT" => [
                    "type" => "text",
                    'class' => 'field w-100',
                    "label" => "Port SMTP",
                    "hint" => "Le port du serveur SMTP",
                    "value" => EMAIL_SMTP_PORT
                ],
            ],
        ];
    }
}
