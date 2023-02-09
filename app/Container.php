<?php

namespace App;

class Container
{
    private static array $instances = [];
    private static \DI\Container $container;

    private function __construct()
    {
        self::$container = new \DI\Container();
    }

    public static function get(string $className)
    {
        return self::getInstance()::$container->get($className);
    }

    private static function getInstance(): Container
    {
        $class = static::class;
        if (!isset(self::$instances[$class])) {
            self::$instances[$class] = new static();
        }
        return self::$instances[$class];
    }
}