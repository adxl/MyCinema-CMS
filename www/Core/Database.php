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
		} catch (Exception $e) {
			die("Erreur SQL : " . $e->getMessage());
		}
	}


	public function findAll($attributes)
	{

		$columns = "";

		foreach ($attributes as $value) {
			$columns .= $value . ", ";
		}

		$columns = trim($columns, ', ');


		$query = "SELECT " . $columns . " FROM " . $this->table;
		$stmt = $this->pdo->prepare($query);

		$stmt->execute();

		$data = $stmt->fetchAll(\PDO::FETCH_ASSOC);

		return $data;
	}

	public function findById ($id) {
		return $this->findOne(['id' => $id]);
	}

	public function findOne($conditions)
	{

		$where = "";
		$data = [];
		foreach ($conditions as $key => $value) {
			$where .=  $key . "= :" . $key;
			$where .= " AND ";

			$data[$key] = $value;
		}

		$where = trim($where, " AND ");

		$query = "SELECT * FROM " . $this->table . " WHERE " . $where;
		$stmt = $this->pdo->prepare($query);

		$stmt->execute($data);

		$data = $stmt->fetch(\PDO::FETCH_ASSOC);

		return $data;
	}

	public function save()
	{
		$column = array_diff_key(
			get_object_vars($this),
			get_class_vars(get_class())
		);

		if (is_null($this->getId())) {

			$query = "	INSERT INTO " . $this->table . "(" . implode(',', array_keys($column)) . ") 
						VALUES (:" . implode(',:', array_keys($column)) . ") ";
		} else {
			$query = "UPDATE ". $this->table . " SET " . implode(' = , ', array_keys($column)) . " = ? WHERE id = ?";
			$column['id'] = $this->getId();
		}
		$stmt = $this->pdo->prepare($query);
		$stmt->execute($column);
	}
}
