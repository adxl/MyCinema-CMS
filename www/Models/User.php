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
					"value" => "adelsen@mycinema.com",   // DEBUG: login rapide
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
				"submit" => "Submit",
			],
			"inputs" => [

				"firstName" => [
					"type" => "text",
					'class' => 'field w-25',
					"label" => "First name",
					"value" => $data['firstname'],
					"required" => true,
					"minLength" => 2,
					"maxLength" => 50,
					"error" => "First name should be between 2 and 50 characters"
				],

				"lastName" => [
					"type" => "text",
					'class' => 'field w-25',
					"label" => "Last name",
					"value" => $data['lastname'],
					"required" => true,
					"minLength" => 2,
					"maxLength" => 100,
					"error" => "Last name should be between 2 and 100 characters"
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
				"submit" => "Submit",
			],
			"inputs" => [
				"email" => [
					"type" => "email",
					'class' => 'field w-25',
					"placeholder" => "example@email.com",
					"label" => "Email",
					"value" => $data['email'],
					"required" => true,
					"error" => "Not a valid email"
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
				"submit" => "Submit",
			],
			"inputs" => [

				"actualPwd" => [
					"type" => "text",
					'class' => 'field w-50',
					"label" => "Actual password",
					"required" => true,
					"error" => "Password should have at least 8 characters"
				],

				"pwd" => [
					"type" => "text",
					'class' => 'field w-50',
					"label" => "New password",
					"required" => true,
					"error" => "Password should have at least 8 characters"
				],

				"pwdConfirm" => [
					"type" => "text",
					'class' => 'field w-50 mb-xl',
					"label" => "Confirm new password",
					"required" => true,
				],
			]
		];
	}
}
