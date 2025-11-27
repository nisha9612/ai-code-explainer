<?php
namespace App\Core;

class App {
    public function run() {
        // Basic router initialization
        $router = new Router();

        // Register routes
        $router->post('/explain', 'ExplainController@explain');

        // Dispatch current request
        $router->dispatch();
    }
}
