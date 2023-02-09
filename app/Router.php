<?php

namespace App;

use App\Responses\Json;
use App\Responses\Redirect;
use App\Responses\Template;
use FastRoute\{Dispatcher, RouteCollector};
use function FastRoute\simpleDispatcher;

require_once 'routes/web.php';
require_once 'routes/api.php';

class Router
{
    private static array $instances = [];
    private static Dispatcher $dispatcher;

    public function __construct()
    {
        self::$dispatcher = simpleDispatcher(function (RouteCollector $routeCollector) {
            foreach (ROUTES as $route) {
                $routeCollector->addRoute($route[0], $route[1], $route[2]);
            }

            foreach (API_ROUTES as $route) {
                $routeCollector->addRoute($route[0], $route[1], $route[2]);
            }
        });
    }

    public static function handleUri(): void
    {
        self::getInstance();
        $httpMethod = $_SERVER["REQUEST_METHOD"];
        $uri = $_SERVER["REQUEST_URI"];
        if (false !== $pos = strpos($uri, "?")) {
            $uri = substr($uri, 0, $pos);
        }
        $uri = rawurldecode($uri);
        $routeInfo = self::$dispatcher->dispatch($httpMethod, $uri);
        switch ($routeInfo[0]) {
            case Dispatcher::NOT_FOUND:
                Application::render('404');
                break;
            case Dispatcher::METHOD_NOT_ALLOWED:
                Application::render('405', [
                    "allowedMethods" => $routeInfo[1],
                ]);
                break;
            case Dispatcher::FOUND:
                $handler = $routeInfo[1];
                $vars = $routeInfo[2];
                [$controller, $method] = $handler;
                $response = call_user_func_array([Container::get($controller), $method], $vars);
                if ($response instanceof Template) {
                    Application::render($response->getPath(), $response->getParameters());
                } elseif ($response instanceof Redirect) {
                    Application::redirect($response->getPath());
                } elseif ($response instanceof Json) {
                    http_response_code($response->getCode());
                    echo $response->getJson();
                }
        }
    }

    private static function getInstance(): void
    {
        $class = static::class;
        if (!isset(self::$instances[$class])) {
            self::$instances[$class] = new static();
        }
    }
}