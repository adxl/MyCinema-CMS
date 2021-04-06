<?php

namespace App\Core;


class Database
{

	private $pdo;
	private $table;

	public function __construct()
	{

		try {
			$this->pdo = new \PDO(DBDRIVER . ":host=" . DBHOST . ";dbname=" . DBNAME . ";port=" . DBPORT, DBUSER, DBPWD);
			$classExploded = explode("\\", get_called_class());
			$this->table = strtolower(DBPREFIXE . end($classExploded));
			$query = $this->pdo->prepare("SELECT * FROM faman_user");
			$query->execute();
		} catch (Exception $e) {
			die("Erreur SQL : " . $e->getMessage());
		}
	}


	public function save()
	{

		array(
			['firstname'] => 'adel',
			['lastname'] => 'sen',
			['email'] => 'adelsen@gmail.com',
			['pwd'] => 'pass',
			['address'] => '12 rue de la lune',
			['city'] => 'Paris',
			['zipcode'] => '93100',
			['birthdate'] => 'status',
		);

		$column = array_diff_key(
			get_object_vars($this),
			get_class_vars(get_class())
		);

		if (is_null($this->getId())) {
			//INSERT


			$query = $this->pdo->prepare("INSERT INTO " . $this->table . " 
						(" . implode(',', array_keys($column)) . ") 
						VALUES 
						(:" . implode(',:', array_keys($column)) . ") "); //1 

		} else {
			//UPDATE

		}


		$query->execute($column);
	}
}
