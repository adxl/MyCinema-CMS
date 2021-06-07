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

	// full name

	public function getFullName(): string
	{
		return $this->firstname . " " . $this->lastname;
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


	public function formBuilderLogin()
	{
		return  [
			"config" => [
				"method" => "POST",
				"action" => "/bo/login",
				"id" => "form_login",
				"submit" => "Connexion",
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
				],

				"password" => [
					"type" => "password",
					'class' => 'field w-100',
					"placeholder" => "********",
					"label" => "Mot de passe",
					"value" => "password",  // DEBUG: login rapide
					"required" => true,
				],

				"forgotPassword" => [
					"type" => "button",
					"value" => "Mot de passe oublié ?",
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
				]
			]
		];
	}

	public function formBuilderAccountNames($data)
	{
		return  [
			"config" => [
				"method" => "POST",
				"action" => "/bo/account/names",
				"id" => "form_account_names",
				"submit" => "Enregistrer",
			],
			"inputs" => [

				"firstName" => [
					"type" => "text",
					'class' => 'field w-25',
					"label" => "Prénom",
					"value" => $data['firstname'],
					"required" => true,
					"minLength" => 2,
					"maxLength" => 50,
				],

				"lastName" => [
					"type" => "text",
					'class' => 'field w-25',
					"label" => "Nom",
					"value" => $data['lastname'],
					"required" => true,
					"minLength" => 2,
					"maxLength" => 100,
				],
			]
		];
	}

	public function formBuiderAccountEmail($data)
	{
		return  [
			"config" => [
				"method" => "POST",
				"action" => "/bo/account/email",
				"id" => "form_account_email",
				"submit" => "Enregistrer",
			],
			"inputs" => [
				"email" => [
					"type" => "email",
					'class' => 'field w-25',
					"placeholder" => "example@email.com",
					"label" => "Email",
					"value" => $data['email'],
					"required" => true,
				],
			]
		];
	}

	public function formBuilderAccountPassword()
	{
		return  [
			"config" => [
				"method" => "POST",
				"action" => "/bo/account/password",
				"id" => "form_account_password",
				"submit" => "Enregistrer",
			],
			"inputs" => [

				"actualPwd" => [
					"type" => "text",
					'class' => 'field w-50',
					"label" => "Mot de passe actuel",
					"required" => true,
				],

				"pwd" => [
					"type" => "text",
					'class' => 'field w-50',
					"label" => "Nouveau mot de passe",
					"required" => true,
				],

				"pwdConfirm" => [
					"type" => "text",
					'class' => 'field w-50 mb-xl',
					"label" => "Confirmer le nouveau mot de passe",
					"required" => true,
				],
			]
		];
	}
}
