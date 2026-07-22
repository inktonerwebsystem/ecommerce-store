<?php
class Router {
    public static function run() {
        // Cambia 'HomeController' por 'IndexController'
        $controllerName = isset($_GET['controller']) ? ucfirst($_GET['controller']) . 'Controller' : 'IndexController';
        $action = isset($_GET['action']) ? $_GET['action'] : 'index';

        $controllerPath = 'controllers/' . $controllerName . '.php';

        if (file_exists($controllerPath)) {
            require_once $controllerPath;
            if (class_exists($controllerName)) {
                $controller = new $controllerName();
                if (method_exists($controller, $action)) {
                    $controller->$action();
                } else {
                    die("Acción '$action' no encontrada en el controlador '$controllerName'.");
                }
            } else {
                die("Controlador '$controllerName' no encontrado.");
            }
        } else {
            die("Archivo de controlador '$controllerPath' no encontrado.");
        }
    }
}