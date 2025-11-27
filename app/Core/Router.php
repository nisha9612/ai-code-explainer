<?php
namespace App\Core;

class Router {
    private $routes = [];

    public function post($uri, $action) {
        $this->routes['POST'][$uri] = $action;
    }

    public function dispatch() {
        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        if (!isset($this->routes[$method][$uri])) {
            http_response_code(404);
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Route not found: ' . $uri]);
            return;
        }

        $action = $this->routes[$method][$uri];
        list($controllerName, $methodName) = explode('@', $action);

        $controllerClass = '\\App\\Controllers\\' . $controllerName;
        if (!class_exists($controllerClass)) {
            http_response_code(500);
            echo json_encode(['error' => 'Controller not found: ' . $controllerClass]);
            return;
        }

        $controller = new $controllerClass();
        $controller->$methodName();
    }
}
