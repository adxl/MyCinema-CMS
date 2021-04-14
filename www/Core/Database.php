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


	public function findAll($sqlData = [])
	{
		if (!isset($sqlData['select'])) {
			$sqlData['select'] = '*';
		}

		$columns = $sqlData['select'];

		$data = [];
		$where = "";

		if (array_key_exists('where', $sqlData)) {
			foreach ($sqlData['where'] as $cond) {
				$where .=  $cond['column'] . " " . $cond['operator'] . " :" . $cond['column'];
				$where .= " AND ";

				$data[$cond['column']] = $cond['value'];
			}
			$where = trim($where, " AND ");
		}


		$order = "";
		if (array_key_exists('order', $sqlData)) {
			$order = " ORDER BY " . $sqlData['order']['column'] . " " . $sqlData['order']['order'];
		}


		$query = "SELECT " . $columns . " FROM " . $this->table . ($where ? " WHERE " . $where : "") . $order;
		$stmt = $this->pdo->prepare($query);

		echo "<pre>";
		echo $query . PHP_EOL;
		echo "</pre>";

		$stmt->execute($data);

		$data = $stmt->fetchAll(\PDO::FETCH_ASSOC);

		return $data;
	}

	public function findById($id)
	{
		return $this->findOne(['id' => $id]);
	}

	public function findOne($whereClause)
	{

		$where = "";
		$data = [];
		foreach ($whereClause as $key => $value) {
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

			$stmt = $this->pdo->prepare($query);
		} else {
			$query = "UPDATE " . $this->table . " SET " . implode(' = , ', array_keys($column)) . " = ? WHERE id = ?";
			$column['id'] = $this->getId();
		}
		$stmt = $this->pdo->prepare($query);
		$stmt->execute($column);
	}
}
