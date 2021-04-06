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
	public function setId($id): void
	{
		$this->id = $id;
	}

	// firstname

	public function getFirstname()
	{
		return $this->firstname;
	}
	public function setFirstname($firstname): void
	{
		$this->firstname = $firstname;
	}

	// lastname

	public function getLastname()
	{
		return $this->lastname;
	}
	public function setLastname($lastname): void
	{
		$this->lastname = $lastname;
	}

	// email

	public function getEmail()
	{
		return $this->email;
	}
	public function setEmail($email): void
	{
		$this->email = $email;
	}

	// password

	public function getPwd()
	{
		return $this->pwd;
	}
	public function setPwd($pwd): void
	{
		$this->pwd = $pwd;
	}

	// address

	public function getAddress()
	{
		return $this->address;
	}
	public function setAddress($address): void
	{
		$this->address = $address;
	}

	// city

	public function getRole(): int
	{
		return $this->role;
	}
	public function setRole(int $role): void
	{
		$this->role = $role;
	}

	// zipcode

	public function getZipcode(): int
	{
		return $this->zipcode;
	}
	public function setZipCode(int $zipcode): void
	{
		$this->zipcode = $zipcode;
	}

	// birthdate

	public function getBirthdate(): int
	{
		return $this->birthdate;
	}
	public function setBirthdate(int $birthdate): void
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


	public function getIsDeleted(): int
	{
		return $this->isDeleted;
	}
	public function setIsDeleted(int $isDeleted): void
	{
		$this->isDeleted = $isDeleted;
	}
}
