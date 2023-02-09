<?php

namespace App;

use App\Repositories\AnimalsRepository;
use App\Repositories\PostgresSqlAnimalsRepository;
use function DI\create;

class Container
{
    private static array $instances = [];
    private static \DI\Container $container;

    private function __construct()
    {
        self::$container = new \DI\Container();
        self::$container->set(
            AnimalsRepository::class,
            create(PostgresSqlAnimalsRepository::class)
        );
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