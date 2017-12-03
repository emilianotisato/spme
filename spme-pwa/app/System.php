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
}
