<?php

function handleError(string $errorText): string
{
    return "\033[31m" . $errorText . " \r\n \033[97m";
}

function handleHelp(): string
{
    $help = "Программа работы с файловым хранилищем \r\n";

    $help .= "Порядок вызова\r\n\r\n";

    $help .= "php /code/app.php [COMMAND] \r\n\r\n";

    $help .= "Доступные команды: \r\n";
    $help .= "read-all - чтение всего файла \r\n";
    $help .= "add - добавление записи \r\n";
    $help .= "clear - очистка файла \r\n";
    $help .= "read-profiles - вывести список профилей пользователей \r\n";
    $help .= "read-profile - вывести профиль выбранного пользователя \r\n";
    $help .= "help - помощь \r\n";

    return $help;
}

// Получение корректной формы слова при разном количестве
function get_word($number, $word1, $word2, $word3)
{
    if ($number > 10 && $number <= 20) return $word1;
    else {
        return match ($number % 10) {
            1 => $word2,
            2, 3, 4 => $word3,
            default => $word1,
        };
    }
}
