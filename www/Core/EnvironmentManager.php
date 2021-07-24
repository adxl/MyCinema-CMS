<?php

namespace App\Core;

class EnvironmentManager
{
    public static function getEnvData($envFile)
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

    public static function writeEnvData($data, $envFile)
    {
        $dataString = "";
        foreach ($data as $key => $value) {
            $dataString .= $key . "=" . $value . PHP_EOL;
        }
        file_put_contents($envFile, $dataString);
    }

    public static function updateGeneralEnv($data)
    {
        $data['DB_ENV'] = DB_ENV;
        EnvironmentManager::writeEnvData($data, ".env");
    }

    public static function updateDatabaseEnv($data)
    {
        $data['DB_DRIVER'] = DB_DRIVER;
        $data['DB_PORT'] = DB_PORT;
        $data['DB_PREFIXE'] = DB_PREFIXE;
        EnvironmentManager::writeEnvData($data, ".env.db" . DB_ENV);
    }

    public static function updateMailingEnv($data)
    {
        EnvironmentManager::writeEnvData($data, ".env.smtp");
    }
}
