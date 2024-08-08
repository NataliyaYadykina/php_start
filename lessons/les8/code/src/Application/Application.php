<?php

namespace Geekbrains\Application1\Application;

use Geekbrains\Application1\Infrastructure\Config;
use Geekbrains\Application1\Infrastructure\Storage;
use Geekbrains\Application1\Application\Auth;
use Geekbrains\Application1\Domain\Controllers\AbstractController;
use Monolog\Handler\FirePHPHandler;
use Monolog\Logger;
use \Monolog\Handler\StreamHandler;
use Monolog\Level;

final class Application
{

    private const APP_NAMESPACE = 'Geekbrains\Application1\Domain\Controllers\\';

    private string $controllerName;
    private string $methodName;

    // текстовый файл с днями рождения
    private static array $config_bdays;

    // config/config.ini
    public static Config $config;
    public static Storage $storage;
    public static Auth $auth;
    
    public static Logger $logger;

    public function __construct()
    {
        Application::$config = new Config();
        Application::$storage = new Storage();
        Application::$auth = new Auth();
        
        Application::$logger = new Logger('application_logger');
        Application::$logger->pushHandler(new StreamHandler(
            $_SERVER['DOCUMENT_ROOT'] . "/log/" . Application::$config->get()['log']['LOGS_FILE'] . "-" . date("Y-m-d") . ".log",
            Level::Debug
        ));

        Application::$logger->pushHandler(new FirePHPHandler());
    }

    public static function config_bdays(): array
    {
        return Application::$config_bdays;
    }

    public function run(): string
    {

        session_start();
        Application::$auth->restoreSession();

        $routeArray = explode('/', $_SERVER['REQUEST_URI']);

        Application::$config_bdays = parse_ini_file('config.ini', true);

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

                if ($controllerInstance instanceof AbstractController) {
                    if ($this->checkAccessToMethod($controllerInstance, $this->methodName)) {
                        return call_user_func_array(
                            [$controllerInstance, $this->methodName],
                            []
                        );
                    } else {
                        return "Нет доступа к методу";
                    }
                } else {
                    //$method = $this->methodName;
                    //return $controllerInstance->$method();
                    return call_user_func_array(
                        [$controllerInstance, $this->methodName],
                        []
                    );
                }
            } else {
            	$logMessage = "Метод {$this->methodName} не существует в контроллере {$this->controllerName} | ";
                $logMessage .= "Попытка вызова адреса {$_SERVER['REQUEST_URI']}";
                Application::$logger->error($logMessage);
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

    private function checkAccessToMethod(
        AbstractController $controllerInstance,
        string $methodName
    ): bool {
        $userRoles = $controllerInstance->getUserRoles();
        $rules = $controllerInstance->getActionsPermissions($methodName);
        $rules[] = 'user';
        $isAllowed = false;
        if (!empty($rules)) {
            foreach ($rules as $rolePermission) {
                if (in_array($rolePermission, $userRoles)) {
                    $isAllowed = true;
                    break;
                }
            }
        }
        return $isAllowed;
    }
}

