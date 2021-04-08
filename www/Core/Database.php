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

			echo $this->table;
		} catch (Exception $e) {
			die("Erreur SQL : " . $e->getMessage());
		}
	}


	public function save()
	{

		$column = array_diff_key(
			get_object_vars($this),
			get_class_vars(get_class())
		);

		if (is_null($this->getId())) {

			$query = "INSERT INTO " . $this->table . "(" . implode(',', array_keys($column)) . ") 
			VALUES (:" . implode(',:', array_keys($column)) . ") ";

			$stmt = $this->pdo->prepare($query); //1 

		} else {
		}

		echo "<pre>";
		print_r($column);
		echo "</pre>";

		echo $query . PHP_EOL;

		$stmt->execute($column);
	}
}
