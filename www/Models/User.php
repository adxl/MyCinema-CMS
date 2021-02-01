<?php

namespace App\Models;

use App\Core\Database;

class User extends Database
{

	private $id = null;
	protected $firstname;
	protected $lastname;
	protected $email;
	protected $pwd;
	protected $country;
	protected $role = 0;
	protected $status = 1;
	protected $isDeleted = 0;

	/*
		role
		status
		createdAt
		updatedAt
		isDeleted (hard delete du soft delete) attention au RGPD
	*/


	public function __construct()
	{
		parent::__construct();
	}

	//Parse error: syntax error, unexpected 'return' (T_RETURN) in /var/www/html/Models/User.php on line 41

	/**
	 * @return mixed
	 */
	public function getId()
	{
		return $this->id;
	}
	/**
	 * @param mixed $id
	 */
	public function setId($id): void
	{
		$this->id = $id;

		//ON doit peupler (populate) l'objet avec les valeurs de la bdd ...

	}

	/**
	 * @return mixed
	 */
	public function getFirstname()
	{
		return $this->firstname;
	}
	/**
	 * @param mixed $firstname
	 */
	public function setFirstname($firstname): void
	{
		$this->firstname = $firstname;
	}

	/**
	 * @return mixed
	 */
	public function getLastname()
	{
		return $this->lastname;
	}
	/**
	 * @param mixed $lastname
	 */
	public function setLastname($lastname): void
	{
		$this->lastname = $lastname;
	}
	/**
	 * @return mixed
	 */
	public function getEmail()
	{
		return $this->email;
	}
	/**
	 * @param mixed $email
	 */
	public function setEmail($email): void
	{
		$this->email = $email;
	}
	/**
	 * @return mixed
	 */
	public function getPwd()
	{
		return $this->pwd;
	}
	/**
	 * @param mixed $pwd
	 */
	public function setPwd($pwd): void
	{
		$this->pwd = $pwd;
	}
	/**
	 * @return mixed
	 */
	public function getCountry()
	{
		return $this->country;
	}
	/**
	 * @param mixed $country
	 */
	public function setCountry($country): void
	{
		$this->country = $country;
	}
	/**
	 * @return int
	 */
	public function getRole(): int
	{
		return $this->role;
	}
	/**
	 * @param int $role
	 */
	public function setRole(int $role): void
	{
		$this->role = $role;
	}
	/**
	 * @return int
	 */
	public function getStatus(): int
	{
		return $this->status;
	}
	/**
	 * @param int $status
	 */
	public function setStatus(int $status): void
	{
		$this->status = $status;
	}
	/**
	 * @return int
	 */
	public function getIsDeleted(): int
	{
		return $this->isDeleted;
	}
	/**
	 * @param int $isDeleted
	 */
	public function setIsDeleted(int $isDeleted): void
	{
		$this->isDeleted = $isDeleted;
	}
}
