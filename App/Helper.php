<?php

namespace App;

use PDO;

class Helper
{
    use \Core\Singleton;

    public static function getDB()
    {
        static $db = null;

        if ($db === null) {
            $dsn = 'mysql:host=' . Config::get()->DB_HOST . ';dbname=' . Config::get()->DB_DATABASE . ';charset=utf8';
            $db = new PDO($dsn, Config::get()->DB_USERNAME, Config::get()->DB_PASSWORD);

            // Throw an Exception when an error occurs
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        return $db;
    }
}
