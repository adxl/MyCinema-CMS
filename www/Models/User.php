<?php

namespace App\Models;

use App\Core\Database;

class User extends Database
{
	private $id = null;

	// required
	protected $firstname;
	protected $lastname;
	protected $email;
	protected $password;
	protected $role = 'MANAGER';
	protected $isActive = 0;
	protected $isDeleted = 0;


	public function __construct()
	{
		parent::__construct();
	}

	// id

	public function getId()
	{
		return $this->id;
	}
	public function setId($id)
	{
		$this->id = $id;
	}

	// firstname

	public function getFirstname(): string
	{
		return $this->firstname;
	}
	public function setFirstname(string $firstname): void
	{
		$this->firstname = ucfirst($firstname);
	}

	// lastname

	public function getLastname(): string
	{
		return $this->lastname;
	}
	public function setLastname(string $lastname): void
	{
		$this->lastname = ucfirst($lastname);
	}

	// email

	public function getEmail(): string
	{
		return $this->email;
	}
	public function setEmail(string $email): void
	{
		$this->email = strtolower($email);
	}

	// password

	public function getPassword(): string
	{
		return $this->password;
	}
	public function setPassword(string $pwd): void
	{
		$this->password = $pwd;
	}

	// role

	public function getRole(): int
	{
		return $this->role;
	}
	public function setRole($role): void
	{
		$this->role = $role;
	}

	// is active ?

	public function getIsActive()
	{
		return $this->isActive;
	}
	public function setIsActive($isActive): void
	{
		$this->isActive = $isActive;
	}

	// is deleted ?

	public function getIsDeleted()
	{
		return $this->isDeleted;
	}
	public function setIsDeleted($isDeleted): void
	{
		$this->isDeleted = $isDeleted;
	}

	public function formBuilderLogin()
	{
		return  [
			"config" => [
				"method" => "POST",
				"action" => "/bo/login",
				"id" => "form_login",
				"submit" => "Login",
				"submitClass" => 'w-50'
			],
			"inputs" => [

				"email" => [
					"type" => "email",
					'class' => 'field w-100',
					"placeholder" => "example@email.com",
					"label" => "Email",
					"required" => true,
					"value" => "adel@sen.com",   // DEBUG: login rapide
					"error" => "Not a valid email"
				],

				"password" => [
					"type" => "password",
					'class' => 'field w-100',
					"placeholder" => "********",
					"label" => "Password",
					"value" => "password",  // DEBUG: login rapide
					"required" => true,
				],

				"forgotPassword" => [
					"type" => "button",
					"value" => "Forgot password ?",
					'class' => 'link mb-l'
				],
			]
		];
	}

	public function formBuilderRegister()
	{
		return  [
			"config" => [
				"method" => "POST",
				"action" => "/bo/register",
				"id" => "form_register",
				"submit" => "Confirmer",
				"submitClass" => 'w-25 p-m',
				'cancel' => 'Annuler',
				'cancel_action' => '/bo/users'
			],
			"inputs" => [

				"firstName" => [
					"type" => "text",
					'class' => 'field w-100',
					"label" => "First name",
					"required" => true,
					"minLength" => 2,
					"maxLength" => 50,
					"error" => "First name should be between 2 and 50 characters"
				],

				"lastName" => [
					"type" => "text",
					'class' => 'field w-100',
					"label" => "Last name",
					"required" => true,
					"minLength" => 2,
					"maxLength" => 100,
					"error" => "Last name should be between 2 and 100 characters"
				],

				"email" => [
					"type" => "email",
					'class' => 'field w-100 mt-l mb-l',
					"placeholder" => "example@email.com",
					"label" => "Email",
					"required" => true,
					"minLength" => 6,
					"maxLength" => 320,
					"error" => "Not a valid email"
				],

				"pwd" => [
					"type" => "password",
					'class' => 'field w-100',
					"label" => "Password",
					"required" => true,
					"minLength" => 8,
					"maxLength" => 255,
					"value" => "password",  // DEBUG: register rapide
					"error" => "Password should have at least 8 characters"
				],

				"pwdConfirm" => [
					"type" => "password",
					'class' => 'field w-100 mb-xl',
					"label" => "Confirm password",
					"minLength" => 8,
					"maxLength" => 255,
					"value" => "password",  // DEBUG: register rapide
					"required" => true,
				],
			]
		];
	}

	public function formBuilderProfilNames($firstname, $lastname)
    {
        return  [
            "config" => [
                "method" => "POST",
                "action" => "/bo/profile/names",
                "id" => "form_profil_names",
                "submit" => "Submit",
                "submitClass" => 'w-50'
            ],
            "inputs" => [

                "firstName" => [
                    "type" => "text",
                    'class' => 'field w-100',
                    "label" => "First name",
                    "value" => $firstname,
                    "required" => true,
                    "minLength" => 2,
                    "maxLength" => 50,
                    "error" => "First name should be between 2 and 50 characters"
                ],

                "lastName" => [
                    "type" => "text",
                    'class' => 'field w-100',
                    "label" => "Last name",
                    "value" => $lastname,
                    "required" => true,
                    "minLength" => 2,
                    "maxLength" => 100,
                    "error" => "Last name should be between 2 and 100 characters"
                ],
            ]
        ];
    }

    public function formBuiderProfilEmail($email)
    {
        return  [
            "config" => [
                "method" => "POST",
                "action" => "/bo/profile/email",
                "id" => "form_profil_email",
                "submit" => "Submit",
                "submitClass" => 'w-50'
            ],
            "inputs" => [

                "email" => [
                    "type" => "email",
                    'class' => 'field w-100',
                    "placeholder" => "example@email.com",
                    "label" => "Email",
                    "value" => $email,
                    "required" => true,
                    "error" => "Not a valid email"
                ],
            ]
        ];
    }
}
