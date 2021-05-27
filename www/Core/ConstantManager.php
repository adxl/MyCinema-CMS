<?php

namespace App\Core;

class ConstantManager
{

    private $envFile = ".env";
    private $data = [];

    public function __construct()
    {
        if (!file_exists($this->envFile))
            die("Error - File Not Found : env file ( " . $this->envFile . " ) does not exist [ConstantManager.php]");

        $this->parsingEnv($this->envFile);

        if (!empty($this->data["ENV"])) {
            $newFile = $this->envFile . "." . $this->data["ENV"];

            if (!file_exists($newFile))
                die("Error - File Not Found : File ( " . $newFile . " ) does not exist [ConstantManager.php]");

            $this->parsingEnv($newFile);
        }

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
