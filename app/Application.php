<?php

namespace App;

class Application
{
    public static function render(string $view, array $variables = []): array
    {
        if (!empty($variables)) {
            extract($variables);
        }
        require_once "../views/" . $view . ".php";
        return $variables;
    }

    public static function redirect(string $path): void
    {
        header("Location: " . $path);
        exit();
    }
}