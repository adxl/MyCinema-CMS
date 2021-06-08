<?php

namespace App\Models;

class Settings
{

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
                "db-host" => [
                    "type" => "text",
                    'class' => 'field w-100',
                    "label" => "Serveur",
                    "value" => DB_HOST,
                ],
                "db-driver" => [
                    "type" => "text",
                    'class' => 'field w-100',
                    "label" => "Pilote (driver)",
                    "value" => DB_DRIVER,
                ],
                "db-port" => [
                    "type" => "text",
                    'class' => 'field w-100 mb-l',
                    "label" => "Port",
                    "value" => DB_PORT,
                ],
                "db-name" => [
                    "type" => "text",
                    'class' => 'field w-100',
                    "label" => "Nom",
                    "value" => DB_NAME,
                ],
                "db-prefixe" => [
                    "type" => "text",
                    'class' => 'field w-100 mb-l',
                    "label" => "Préfixe",
                    "value" => DB_PREFIXE,
                ],
                "db-user" => [
                    "type" => "text",
                    'class' => 'field w-100',
                    "label" => "Utilisateur",
                    "value" => DB_USER,
                ],
                "db-password" => [
                    "type" => "password",
                    'class' => 'field w-100',
                    "label" => "Mot de passe",
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
                "email-source-name" => [
                    "type" => "text",
                    'class' => 'field w-100',
                    "label" => "Nom",
                    "value" => EMAIL_SOURCE_NAME,
                ],
                "email-source-address" => [
                    "type" => "text",
                    'class' => 'field w-100 mb-l',
                    "label" => "Adresse",
                    "value" => EMAIL_SOURCE_ADDRESS,
                ],
                "email-smtp-host" => [
                    "type" => "text",
                    'class' => 'field w-100',
                    "label" => "Serveur SMTP",
                    "value" => EMAIL_SMTP_HOST,
                ],
                "email-smtp-admin" => [
                    "type" => "text",
                    'class' => 'field w-100',
                    "label" => "Adresse SMTP",
                    "value" => EMAIL_SMTP_ADMIN,
                ],
                "email-smtp-password" => [
                    "type" => "password",
                    'class' => 'field w-100',
                    "label" => "Mot de passe SMTP",
                    "value" => EMAIL_SMTP_PASSWORD,
                ],
                "email-smtp-port" => [
                    "type" => "text",
                    'class' => 'field w-100 mb-l',
                    "label" => "Port SMTP",
                    "value" => EMAIL_SMTP_PORT,
                ],
            ],
        ];
    }
}
