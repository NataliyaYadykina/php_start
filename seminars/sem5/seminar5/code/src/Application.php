<?php

namespace Geekbrains\Application1;

final class Application
{

    private const APP_NAMESPACE = 'Geekbrains\Application1\Controllers\\';

    private string $controllerName;
    private string $methodName;
    private static array $config;

    public static function config(): array
    {
        return Application::$config;
    }

    public function run(): string
    {

        $routeArray = explode('/', $_SERVER['REQUEST_URI']);

        Application::$config = parse_ini_file('config.ini', true);

        if (isset($routeArray[1]) && $routeArray[1] != '') {
            $controllerName = $routeArray[1];
        } else {
            $controllerName = "page";
        }

        $this->controllerName = Application::APP_NAMESPACE . ucfirst($controllerName) . "Controller";

        if (class_exists($this->controllerName)) {
            // пытаемся вызвать метод
            if (isset($routeArray[2]) && $routeArray[2] != '') {
                $methodName = $routeArray[2];
            } else {
                $methodName = "index";
            }

            $this->methodName = "action" . ucfirst($methodName);

            if (method_exists($this->controllerName, $this->methodName)) {
                $controllerInstance = new $this->controllerName();
                //$method = $this->methodName;
                //return $controllerInstance->$method();
                return call_user_func_array(
                    [$controllerInstance, $this->methodName],
                    []
                );
            } else {
                // return "Метод не существует";
                header("HTTP/1.1 404 NotFound");
                header("Location: /404.html");
                die();
            }
        } else {
            // return "Класс $this->controllerName не существует";
            header("HTTP/1.1 404 NotFound");
            header("Location: /404.html");
            die();
        }
    }
}
