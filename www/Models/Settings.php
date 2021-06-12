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
                "website-name" => [
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
                "db-host" => [
                    "type" => "text",
                    'class' => 'field w-100',
                    "label" => "Serveur",
                    "hint" => "Votre serveur de base de données (defaut: localhost)",
                    "value" => DB_HOST,
                ],
                "db-driver" => [
                    "type" => "text",
                    'class' => 'field w-100',
                    "label" => "Pilote",
                    "hint" => "Driver de base de données (defaut: mysql)",
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
                    "hint" => "Nom de la base de données",
                    "value" => DB_NAME,
                ],
                "db-prefixe" => [
                    "type" => "text",
                    'class' => 'field w-100 mb-l',
                    "label" => "Préfixe",
                    "hint" => "Préfixe de sécurité des tables",
                    "value" => DB_PREFIXE,
                ],
                "db-user" => [
                    "type" => "text",
                    'class' => 'field w-100',
                    "label" => "Utilisateur",
                    "hint" => "Nom d'utilisateur de la base de données",
                    "value" => DB_USER,
                ],
                "db-password" => [
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
                "email-source-name" => [
                    "type" => "text",
                    'class' => 'field w-100',
                    "label" => "Nom",
                    "hint" => "Le nom affiché au destinataire du mail",
                    "value" => EMAIL_SOURCE_NAME,
                ],
                "email-source-address" => [
                    "type" => "text",
                    'class' => 'field w-100 mb-l',
                    "label" => "Adresse",
                    "required" => true,
                    "hint" => "L'adresse email affichée au destinataire du mail",
                    "value" => EMAIL_SOURCE_ADDRESS,
                ],
                "email-smtp-host" => [
                    "type" => "text",
                    'class' => 'field w-100',
                    "label" => "Serveur SMTP",
                    "required" => true,
                    "hint" => "Votre serveur SMTP",
                    "value" => EMAIL_SMTP_HOST,
                ],
                "email-smtp-admin" => [
                    "type" => "text",
                    'class' => 'field w-100',
                    "label" => "Adresse SMTP",
                    "required" => true,
                    "hint" => "Adresse email de l'admin SMTP",
                    "value" => EMAIL_SMTP_ADMIN,
                ],
                "email-smtp-password" => [
                    "type" => "password",
                    'class' => 'field w-100',
                    "label" => "Mot de passe SMTP",
                    "required" => true,
                    "hint" => "Mot de passe de l'admin SMTP",
                    "value" => EMAIL_SMTP_PASSWORD,
                ],
                "email-smtp-port" => [
                    "type" => "text",
                    'class' => 'field w-100 mb-l',
                    "label" => "Port SMTP",
                    "required" => true,
                    "value" => EMAIL_SMTP_PORT,
                ],
            ],
        ];
    }
}
