<?php

namespace App;

use Dotenv\Dotenv;

/**
 * Application configuration
 *
 */

class Config
{
    use \Core\Singleton;

    public static function get() {
        $dotenv = Dotenv::createImmutable(__DIR__ . './../');
        $dotenv->load();

        return (object)[
            'DB_HOST' => $_ENV['DB_HOST'],
            'DB_DATABASE' => $_ENV['DB_DATABASE'],
            'DB_PASSWORD' => $_ENV['DB_PASSWORD'],
            'DB_USERNAME' => $_ENV['DB_USERNAME'],
            'SHOW_ERRORS' => filter_var($_ENV['SHOW_ERRORS'], FILTER_VALIDATE_BOOLEAN),
            'ENVIRONMENT' => $_ENV['ENVIRONMENT'],
            'SECRET_KEY' => $_ENV['SECRET_KEY']
        ];
    }
}
