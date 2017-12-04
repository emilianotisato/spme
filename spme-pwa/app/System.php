<?php

namespace App;

use DB;

class System
{
    /**
     * Check if is system first installation
     *
     * @return boolean
     */
    public static function isFirstInstall()
    {
        // If we have some version, procede normally
        if (config('installation.version') != null) {
            return false;
        }

        try {
            // Try to establish a PDO connection
            DB::connection()->getPdo();

            dd('System is corrup. You have a correct database conection in your configuration file, but you miss the system version.');
        } catch (\Exception $e) {
            return true;
        }
    }

    /**
     * Set/update enviroment values in the root .env file
     *
     * @param [type] $envKey
     * @param [type] $envValue
     * @return void
     */
    public static function setEnvironmentValue($envKey, $envValue)
    {
        // If we have the key, replace it
        if (preg_match("/^{$envKey}/m", file_get_contents(app()->environmentFilePath()))) {
            file_put_contents(
                app()->environmentFilePath(),
                preg_replace(
                    "/^{$envKey}.*/m", // Replace the complete line
                    $envKey . '=' . $envValue, // By this new key value pair
                    file_get_contents(app()->environmentFilePath())
                )
            );
        } else { // Else append to the file as a new key value pair
            file_put_contents(
                app()->environmentFilePath(),
                $envKey . '=' . $envValue . PHP_EOL,
                FILE_APPEND
            );
        }
    }
}
