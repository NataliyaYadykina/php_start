<?php

$memory_start = memory_get_usage();

require_once(__DIR__ . '/vendor/autoload.php');

use Geekbrains\Application1\Application\Application;

try {
    $app = new Application();
    echo $app->run();
} catch (Exception $e) {
    echo "При старте приложения произошла ошибка. " . $e->getMessage();
}

$memory_end = memory_get_usage();

echo 'Потребление памяти: ' . ($memory_end - $memory_start) / 1024 / 1024 . ' Mb';
