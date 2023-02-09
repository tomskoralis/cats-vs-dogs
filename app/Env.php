<?php

namespace App;

use Dotenv\Dotenv;
use Dotenv\Exception\ValidationException;

class Env
{
    private static array $instances = [];
    private static Dotenv $dotenv;
    private static ?Error $error = null;

    public function __construct()
    {
        self::$dotenv = Dotenv::createImmutable(__DIR__, '../.env');
        self::$dotenv->load();
    }

    public static function getError(): ?Error
    {
        return self::getInstance()::$error;
    }

    public static function get(string $variable): ?string
    {
        self::getInstance();
        return $_ENV[$variable];
    }

    public static function areEmpty($variables): bool
    {
        self::getInstance();
        try {
            self::$dotenv->required($variables)->notEmpty();
        } catch (ValidationException $e) {
            self::$error = new Error(
                'env',
                'Dotenv Exception: ' . $e->getMessage()
            );
            return true;
        }
        return false;
    }

    private static function getInstance(): Env
    {
        $class = static::class;
        if (!isset(self::$instances[$class])) {
            self::$instances[$class] = new static();
        }
        return self::$instances[$class];
    }
}