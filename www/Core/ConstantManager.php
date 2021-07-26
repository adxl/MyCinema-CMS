<?php

namespace App\Core;

class ConstantManager
{

    private $envFile = ".env";
    private $dbFile = ".env.db";
    private $smtpFile = ".env.smtp";
    private $data = [];

    public function __construct()
    {
        // parse default env
        if (!file_exists($this->envFile))
            die("Erreur ENV-E001: Installation corrompue");
        $this->parsingEnv($this->envFile);

        // parse smtp env
        if (!file_exists($this->smtpFile))
            die("Erreur ENV-S001: Installation corrompue");
        $this->parsingEnv($this->smtpFile);

        // parse database env
        if (!file_exists($this->dbFile))
            die("Erreur ENV-D001: Installation corrompue");
        $this->parsingEnv($this->dbFile);

        $this->defineConstants();
    }

    private function defineConstants()
    {
        foreach ($this->data as $key => $value) {
            self::defineConstant($key, $value);
        }
    }


    public static function defineConstant($key, $value)
    {
        if (!defined($key)) {
            define($key, $value);
        } else {
            die("Error - Reserved Constant : " . $key . " is a reserved constant name [ConstantManager.php]");
        }
    }


    public function parsingEnv($file)
    {

        $handle = fopen($file, "r");
        $regex = "/([^=]*)=([^#]*)/";

        if (!empty($handle)) {
            while (!feof($handle)) {

                $line = fgets($handle);
                preg_match($regex, $line, $results);
                if (!empty($results[1]) && !empty($results[2]))
                    $this->data[mb_strtoupper($results[1])] = trim($results[2]);
            }
        }
    }
}
