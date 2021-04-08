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
	protected $pwd;
	protected $address;
	protected $city;
	protected $zipcode;
	protected $birthdate;

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
		return $this->pwd;
	}
	public function setPwd(string $pwd): void
	{
		$this->pwd = $pwd;
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
}
