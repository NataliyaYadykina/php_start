<?php

// Обработка ошибок. Посмотрите на реализацию функции в файле fwrite-cli.php в исходниках. Может ли пользователь ввести некорректную информацию (например, дату в виде 12-50-1548)?
function validateDate(string $date): bool
{
    $dateBlocks = explode("-", $date);

    if (count($dateBlocks) < 3) {
        return false;
    }

    if (isset($dateBlocks[0]) && $dateBlocks[0] > 31) {
        return false;
    }

    if (isset($dateBlocks[1]) && $dateBlocks[1] > 12) {
        return false;
    }

    if (isset($dateBlocks[2]) && $dateBlocks[2] > date('Y')) {
        return false;
    }

    return true;
}

// Какие еще некорректные данные могут быть введены? Исправьте это, добавив соответствующие обработки ошибок.
function validateName(string $name): bool
{
    if (strlen($name) < 3 || strlen($name) > 20) {
        return false;
    }
    return true;
}
