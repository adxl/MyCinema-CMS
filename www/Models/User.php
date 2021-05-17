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

	// not required
	private $address;
	private $city;
	private $zipcode;
	private $birthdate;

	// default
	private $idStatus;
	private $idRole;
	private $isDeleted;


	public function __construct()
	{
		parent::__construct();
	}

	// id

	public function getId()
	{
		return $this->id;
	}
	public function setId(int $id): void
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

	public function getPwd(): string
	{
		return $this->password;
	}
	public function setPwd(string $pwd): void
	{
		$this->password = $pwd;
	}

	// address

	public function getAddress(): string
	{
		return $this->address;
	}
	public function setAddress(string $address): void
	{
		$this->address = $address;
	}

	// city

	public function geCity(): string
	{
		return $this->city;
	}
	public function setCity(string $city): void
	{
		$this->city = $city;
	}

	// zipcode

	public function getZipcode(): string
	{
		return $this->zipcode;
	}
	public function setZipCode(string $zipcode): void
	{
		$this->zipcode = $zipcode;
	}

	// birthdate

	public function getBirthdate()
	{
		return $this->birthdate;
	}
	public function setBirthdate($birthdate): void
	{
		$this->birthdate = $birthdate;
	}

	// status

	public function getIdStatus(): int
	{
		return $this->idStatus;
	}
	public function setIdStatus(int $idStatus): void
	{
		$this->idStatus = $idStatus;
	}

	// role

	public function getIdRole(): int
	{
		return $this->idRole;
	}
	public function setIdRole(int $idRole): void
	{
		$this->idRole = $idRole;
	}


	// is deleted ?


	public function getIsDeleted(): bool
	{
		return $this->isDeleted;
	}
	public function setIsDeleted(bool $isDeleted): void
	{
		$this->isDeleted = $isDeleted;
	}

	public function formBuilderLogin()
	{
		return  [
			"config" => [
				"method" => "POST",
				"action" => "/login",
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
					"value" => "adel-dev@gg.com",   // DEBUG: login rapide
					"error" => "Not a valid email"
				],

				"password" => [
					"type" => "password",
					'class' => 'field w-100',
					"placeholder" => "********",
					"label" => "Password",
					"value" => "azertyui",  // DEBUG: login rapide
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
				"action" => "/register",
				"id" => "form_register",
				"submit" => "Sign up",
				"submitClass" => 'w-50'
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
					"error" => "Password should have at least 8 characters"
				],

				"pwdConfirm" => [
					"type" => "password",
					'class' => 'field w-100 mb-xl',
					"label" => "Confirm password",
					"minLength" => 8,
					"maxLength" => 255,
					"required" => true,
				],
			]
		];
	}
}
