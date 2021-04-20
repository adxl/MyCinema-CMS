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
		} catch (\Exception $e) {
			die("Error - SQL Error : " . $e->getMessage() . " [View.php]");
		}
	}


	public function findAll($sqlData = [])
	{
		if (!isset($sqlData['select'])) {
			$sqlData['select'] = '*';
		}

		$columns = $sqlData['select'];

		$whereData = [];
		$where = "";

		if (array_key_exists('where', $sqlData)) {
			foreach ($sqlData['where'] as $cond) {
				$where .=  $cond['column'] . " " . $cond['operator'] . " :" . $cond['column'];
				$where .= " AND ";

				$whereData[$cond['column']] = $cond['value'];
			}
			$where = preg_replace('/\sAND\s$/', '', $where);
		}

		$order = "";
		if (array_key_exists('order', $sqlData)) {
			$order = " ORDER BY " . $sqlData['order']['column'] . " " . $sqlData['order']['order'];
		}

		$query = "SELECT " . $columns . " FROM " . $this->table . ($where ? " WHERE " . $where : "") . $order;
		$stmt = $this->pdo->prepare($query);

		$stmt->execute($whereData);

		$whereData = $stmt->fetchAll(\PDO::FETCH_ASSOC);

		return $whereData;
	}

	public function findById($id)
	{
		$sqlData = [
			'select' => '*',
			'where' => [
				[
					'column' => 'id',
					'value' => $id,
					'operator' => '='
				]
			]
		];

		return $this->findOne($sqlData);
	}


	public function findOne($sqlData = [])
	{
		if (array_key_exists('where', $sqlData) && sizeof($sqlData['where'])) {

			if (!isset($sqlData['select'])) {
				$sqlData['select'] = '*';
			}

			$columns = $sqlData['select'];

			$whereData = [];
			$where = "";

			foreach ($sqlData['where'] as $cond) {
				$where .=  $cond['column'] . " " . $cond['operator'] . " :" . $cond['column'];
				$where .= " AND ";

				$whereData[$cond['column']] = $cond['value'];
			}
			$where = preg_replace('/\sAND\s$/', '', $where);


			$query = "SELECT " . $columns . " FROM " . $this->table . " WHERE " . $where;
			$stmt = $this->pdo->prepare($query);

			$stmt->execute($whereData);

			$whereData = $stmt->fetch(\PDO::FETCH_ASSOC);

			return $whereData;
		}

		echo "<pre>";
		print_r($sqlData);
		echo "</pre>";
		die("Error - Bad Query : WHERE clause not found [database.php]");
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

			$query = "UPDATE " . $this->table . " SET";

			foreach (array_keys($column) as $key) {
				$query .= " " . $key . " = :" . $key . ",";
			}

			$query = trim($query, ',');
			$query .= " WHERE id = :id";

			$column['id'] = $this->getId();
		}

		$stmt = $this->pdo->prepare($query);
		$stmt->execute($column);
	}
}
