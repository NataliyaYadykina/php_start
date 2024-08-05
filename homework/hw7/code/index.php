<?php


require_once(__DIR__ . '/vendor/autoload.php');

use Geekbrains\Application1\Application\Application;

try {
    $app = new Application();
    echo $app->run();
} catch (Exception $e) {
    echo "При старте приложения произошла ошибка. " . $e->getMessage();
}
