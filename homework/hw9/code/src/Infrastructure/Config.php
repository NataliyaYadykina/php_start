<?php

namespace Geekbrains\Application1\Infrastructure;

class Config
{
    private string $defaultConfigFile = "/src/config/config.ini";

    private array $applicationConfiguration = [];

    public function __construct()
    {
        $address = $_SERVER['DOCUMENT_ROOT'] . "/.." . $this->defaultConfigFile;

        if (file_exists($address) && is_readable($address)) {
            $this->applicationConfiguration = parse_ini_file($address, true);
        } else {
            throw new \Exception("Файл конфигурации не найден.");
        }
    }

    public function get(): array
    {
        return $this->applicationConfiguration;
    }
}


# -- Подключитесь к MySQL как root-пользователь
# -- CREATE DATABASE
# CREATE DATABASE IF NOT EXISTS `name`;

# -- CREATE USER
# CREATE USER IF NOT EXISTS 'user'@'localhost' IDENTIFIED BY '123';

# -- GRANT PRIVILEGES
# GRANT ALL PRIVILEGES ON `name`.* TO 'user'@'localhost';

# -- FLUSH PRIVILEGES
# FLUSH PRIVILEGES;
# ALTER USER 'root'@'localhost' IDENTIFIED BY '856';
# FLUSH PRIVILEGES;

// CREATE TABLE `application1`.`users` (
// `id_user` INT NOT NULL AUTO_INCREMENT,
// `user_name` VARCHAR(45) NULL,
// `user_lastname` VARCHAR(45) Null,
// `user_birthday_timestamp` INT NULL,
// PRIMARY KEY (`id_user`))
// ENGINE = InnoDB
// DEFAULT CHARACTER SET = utf8;
