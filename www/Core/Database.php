<?php

namespace App\Core;

use App\Models\User as UserModel;

class Database
{
    private $pdo;
    private $table;

    public function __construct()
    {
        try {
            $this->pdo = new \PDO(DB_DRIVER . ":host=" . DB_HOST . ";dbname=" . DB_NAME . ";port=" . DB_PORT, DB_USER, DB_PASSWORD);
            $classExploded = explode("\\", get_called_class());
            $this->table = DB_PREFIXE . lcfirst(end($classExploded));
        } catch (\PDOException $e) {
            die("Error - SQL Error : " . $e->getMessage() . " [Database.php]");
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

    public function verifUniqEmail($email)
    {
        $user = new UserModel();


        $emailUsed = $user->findOne(
            [
                'select' => 'COUNT(*) as count',
                'where' => [
                    [
                        'column' => 'email',
                        'operator' => '=',
                        'value' => $_POST["email"]
                    ],
                ]
            ]
        );

        return !($emailUsed['count'] > 0);
    }

    public function findOne($sqlData = [])
    {
        if (!isset($sqlData['select'])) {
            $sqlData['select'] = '*';
        }

        $columns = $sqlData['select'];

        $stmtData = [];
        $where = "";

        if (isset($sqlData['where'])) {
            foreach ($sqlData['where'] as $cond) {
                $where .=  $cond['column'] . " " . $cond['operator'] . " :" . $cond['column'];
                $where .= " AND ";

                $stmtData[$cond['column']] = $cond['value'];
            }
            $where = preg_replace('/\sAND\s$/', '', $where);
        }

        $groupBy = "";

        if (isset($sqlData['groupBy'])) {
            $groupBy =  $sqlData['groupBy'];
        }

        $orderBy = "";

        if (isset($sqlData['orderBy'])) {
            $orderBy =  $sqlData['orderBy']['column'] . " " . $sqlData['orderBy']['order'];
        }

        $query = "SELECT " . $columns . " FROM " . $this->table .
            (!empty($where) ? " WHERE " . $where : '') .
            (!empty($groupBy) ? " GROUP BY " . $groupBy : '') .
            (!empty($orderBy) ? " ORDER BY " . $orderBy : '');


        $stmt = $this->pdo->prepare($query);

        $this->execute($stmt, $stmtData);

        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $result;
    }

    public function save()
    {
        $column = array_diff_key(
            get_object_vars($this),
            get_class_vars(get_class())
        );

        if (is_null($this->getId())) {

            $column['id'] = Helpers::uuid();
            $query = "	INSERT INTO " . $this->table . " (" . implode(',', array_keys($column)) .
                ") VALUES (:" . implode(',:', array_keys($column)) . ") ";

            $stmt = $this->pdo->prepare($query);
        } else {
            $column['id'] = $this->getId();

            $query = "UPDATE " . $this->table . " SET";

            foreach (array_keys($column) as $key) {
                $query .= " " . $key . " = :" . $key . ",";
            }

            $query = trim($query, ',');
            $query .= " WHERE id = :id";
        }

        $stmt = $this->pdo->prepare($query);
        $this->execute($stmt, $column);

        return $column['id'];
    }

    public function deleteById($id)
    {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->pdo->prepare($query);

        $this->execute($stmt, ['id' => $id]);
    }

    public function deleteAll($sqlData = [])
    {
        if (array_key_exists('where', $sqlData) && sizeof($sqlData['where'])) {

            $whereData = [];
            $where = "";

            foreach ($sqlData['where'] as $cond) {
                $where .=  $cond['column'] . " " . $cond['operator'] . " :" . $cond['column'];
                $where .= " AND ";

                $whereData[$cond['column']] = $cond['value'];
            }
            $where = preg_replace('/\sAND\s$/', '', $where);

            $query = "DELETE FROM " . $this->table . " WHERE " . $where;
            $stmt = $this->pdo->prepare($query);

            $this->execute($stmt, $whereData);
        } else {
            echo "<pre>";
            print_r($sqlData);
            echo "</pre>";
            die("Error - Bad Query : WHERE clause not found [database.php]");
        }
    }


    private function execute($stmt, $columns)
    {
        $error = false;
        $stmt->execute($columns) or $error = true;

        if ($error) {
            if (DB_ENV === 'dev') {
                echo "<pre>";
                echo 'DATABASE ERROR : ' . $stmt->errorInfo()[2] . PHP_EOL;
                echo PHP_EOL;
                echo 'IN QUERY : ' . $stmt->queryString . PHP_EOL;
                echo PHP_EOL;
                echo 'WITH DATA : ' . PHP_EOL;
                var_dump($columns);
                echo "</pre>";
            } else {
                Helpers::redirect('/500');
            }
            die();
        }
    }


    public function populate(&$model, $data)
    {
        $columns = array_diff_key(
            get_object_vars($this),
            get_class_vars(get_class())
        );

        $model->setId($data['id']);
        foreach ($columns as $key => $value) {
            $setter = 'set' . ucfirst($key);
            $model->$setter($data[$key]);
        }
    }

    public static function health($access)
    {
        $host = $access["db-host"];
        $driver = $access["db-driver"];
        $port = $access["db-port"];
        $name = $access["db-name"];
        $user = $access["db-user"];
        $password = $access["db-password"];

        try {
            new \PDO($driver . ":host=" . $host . ";dbname=" . $name . ";port=" . $port, $user, $password);
        } catch (\PDOException $e) {
            return false;
        }

        return true;
    }
}
