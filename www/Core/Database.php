<?php

namespace App\Core;

use App\Models\Migrations;
use App\Models\Seeds;
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
            die("Erreur d'environnement ENV-D002: Installation corrompue");
        }
    }

    public function migrate()
    {
        $columns = Migrations::columns();
        $indexes = Migrations::indexes();
        $constraints = Migrations::constraints();

        $this->purge();

        foreach ($columns as $column) {
            $this->createTable($column);
        }

        foreach ($indexes as $index) {
            $this->alterTable($index);
        }

        foreach ($constraints as $constraint) {
            $this->alterTable($constraint);
        }

        $wizardCredentials = $_SESSION["WIZARD_ADMIN_CREDENTIALS"];
        unset($_SESSION["WIZARD_ADMIN_CREDENTIALS"]);

        $admin = new UserModel();
        $admin->setFirstname(htmlspecialchars("Admin"));
        $admin->setLastname(htmlspecialchars("MyCinema"));
        $admin->setEmail(htmlspecialchars($wizardCredentials["email"]));
        $admin->setPassword(password_hash($wizardCredentials['password'], PASSWORD_DEFAULT));
        $admin->setRole("ADMIN");
        $admin->setIsActive(true);
        $id = $admin->save();

        if (!$id) {
            $this->purge();
            unlink(".env");
            die("Une erreur s'est produite durant les migrations");
        }

        $seeds = Seeds::getSeeds();

        foreach ($seeds as $seed) {
            $this->insertSeed($seed);
        }

        return $id;
    }

    private function purge()
    {
        $tables = ["comment", "event", "event_room", "event_tag", "room", "session", "tag", "user", 'website'];
        try {
            $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $this->pdo->exec("SET FOREIGN_KEY_CHECKS = 0;");
            foreach ($tables as $table) {
                $this->pdo->exec("DROP TABLE IF EXISTS " . DB_PREFIXE . $table . ";");
            }
            $this->pdo->exec("SET FOREIGN_KEY_CHECKS = 1;");
        } catch (\PDOException $e) {
            echo $e->getMessage();
            unlink(".env");
            die("purge");
        }
    }

    private function createTable($sql)
    {
        $stmt = "CREATE TABLE IF NOT EXISTS " .  DB_PREFIXE . $sql["table"] . " ( " . $sql["columns"] . " )";

        try {
            $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $this->pdo->exec($stmt);
        } catch (\PDOException $e) {
            echo $e->getMessage();
            unlink(".env");
            die("create");
        }
    }

    private function alterTable($sql)
    {
        $stmt = "ALTER TABLE " .  DB_PREFIXE . $sql["table"] . " " . $sql["columns"] . ";";

        try {
            $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $this->pdo->exec($stmt);
        } catch (\PDOException $e) {
            echo "<pre>";
            echo $stmt . PHP_EOL;
            echo "Error in alter table " . $sql["table"] . PHP_EOL;
            echo $e->getMessage();
            echo "</pre>";
            unlink(".env");
            die("alter");
        }
    }

    private function insertSeed($seed)
    {
        $stmt = "INSERT INTO " .  DB_PREFIXE . $seed["table"] . " VALUES " . $seed["values"];

        try {
            $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $this->pdo->exec($stmt);
        } catch (\PDOException $e) {
            echo $e->getMessage();
            unlink(".env");
            echo "<pre>";
            var_dump($stmt);
            die();
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
                        'value' => $email
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
            if (ENV === 'dev') {
                echo "<pre>";
                echo 'DATABASE ERROR : ' . $stmt->errorInfo()[2] . PHP_EOL;
                echo PHP_EOL;
                echo 'IN QUERY : ' . $stmt->queryString . PHP_EOL;
                echo PHP_EOL;
                echo 'WITH DATA : ' . PHP_EOL;
                var_dump($columns);
                echo "</pre>";
            } else {
                die("Erreur ENV-D002: Installation corrompue");
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

    public static function testConnection($access = [])
    {
        // DB_HOST, DB_DRIVER, DB_PORT, DB_NAME, DB_PREFIXE, DB_USER, DB_PASSWORD
        extract($access);

        $dbstring = ($DB_DRIVER ?? DB_DRIVER) . ":host=" . ($DB_HOST ?? DB_HOST) . ";dbname=" . ($DB_NAME ?? DB_NAME) . ";port=" . ($DB_PORT ?? DB_PORT);

        try {
            new \PDO($dbstring, $DB_USER ?? DB_USER, $DB_PASSWORD ?? DB_PASSWORD);
        } catch (\PDOException $e) {
            return false;
        }
        return true;
    }
}
