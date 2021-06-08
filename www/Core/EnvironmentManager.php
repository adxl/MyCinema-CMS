<?php

namespace App\Core;

class EnvironmentManager
{
    public static function getEnvData($envFile = '.env')
    {
        $file = fopen($envFile, "r");
        $regex = "/([^=]*)=([^#]*)/";

        $data = [];

        if (!empty($file)) {
            while (!feof($file)) {
                $line = fgets($file);
                preg_match($regex, $line, $results);
                if (!empty($results[1]) && !empty($results[2]))
                    $data[mb_strtoupper($results[1])] = trim($results[2]);
            }
        }

        return $data;
    }

    private static function writeEnvData($data, $envFile = '.env')
    {
        $dataString = "";
        foreach ($data as $key => $value) {
            $envKey = strtoupper(str_replace("-", "_", $key));
            $dataString .= $envKey . "=" . $value . PHP_EOL;
        }
        file_put_contents($envFile, $dataString);
    }

    public static function updateDatabaseEnv($data)
    {
        EnvironmentManager::writeEnvData($data, ".env." . ENV);
    }

    public static function updateMailingEnv($data)
    {
        $data['ENV'] = ENV;
        EnvironmentManager::writeEnvData($data);
    }
}
