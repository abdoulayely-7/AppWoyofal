<?php

namespace App\Core;
use App\Config\Middleware;

class Router
{
    public static function resolve(array $routes): void
    {
        $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        foreach ($routes as $route) {
            [$method, $pattern, $handler] = $route;

            // Convertit /api/citoyen/{nci} en regex
            $regex = preg_replace('#\{[^/]+\}#', '([^/]+)', $pattern);
            $regex = "#^" . $regex . "$#";
            
            // var_dump($pattern); die();


            if ($method === $requestMethod && preg_match($regex, $requestUri, $matches)) {
                array_shift($matches); // Retire le match complet
                [$controllerClass, $controllerMethod] = $handler;
                if (class_exists($controllerClass) && method_exists($controllerClass, $controllerMethod)) {
                    $controller = new $controllerClass();
                    $controller->$controllerMethod(...$matches);
                    return;
                }
                // Contrôleur ou méthode non trouvée
                echo "error: Controller or method not found";
                return;
            }
        }

        // 404 si aucune route ne correspond
        echo "error: Endpoint not found";
    }
}
