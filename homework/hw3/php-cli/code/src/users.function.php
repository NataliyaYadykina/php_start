<?php

// Поиск пользователей по имени и/или дате
function findUsers($userData, $nameToSearch = '', $dateToSearch = '')
{
    $foundUsers = [];
    $nameToSearch = mb_strtolower($nameToSearch);

    foreach ($userData as $userDataItem) {
        $name = trim($userDataItem[0]);
        $birthdate = trim($userDataItem[1]);

        // Поиск по имени и/или дате рождения
        if (!empty($nameToSearch) && empty($dateToSearch)) {
            // Ищем пользователей только по имени
            if (strpos(mb_strtolower($name), $nameToSearch) !== false) {
                $foundUsers[array_search($userDataItem, $userData)] = [$name, $birthdate];
            }
        } elseif (empty($nameToSearch) && !empty($dateToSearch)) {
            // Ищем пользователей только по дате рождения
            if (strpos($birthdate, $dateToSearch) !== false) {
                $foundUsers[array_search($userDataItem, $userData)] = [$name, $birthdate];
            }
        } elseif (!empty($nameToSearch) && !empty($dateToSearch)) {
            // Ищем пользователей по указанным имени и дате рождения
            if (strpos(mb_strtolower($name), $nameToSearch) !== false && strpos($birthdate, $dateToSearch) !== false) {
                $foundUsers[array_search($userDataItem, $userData)] = [$name, $birthdate];
            }
        }
    }
    return $foundUsers;
}

// Получение запроса на удаление пользователей
function getQueryUsersDelete()
{
    // Получаем от пользователя имя и/или дату для удаления
    $nameToDelete = readline('Введите имя пользователя для удаления (или нажмите Enter, чтобы пропустить): ');
    $dateToDelete = readline('Введите дату рождения для удаления (в формате dd-mm-yyyy, или нажмите Enter, чтобы пропустить): ');

    return [$nameToDelete, $dateToDelete];
}

// Удаление пользователей из массива
function deleteUsers(array $config)
{
    $content = '';

    $address = $config['storage']['address'];
    $userData = readUserDataFromFile($address);
    list($nameToDelete, $dateToDelete) = getQueryUsersDelete();

    // Проверяем, что хотя бы один критерий для удаления указан
    if (empty($nameToDelete) && empty($dateToDelete)) {
        return handleError("Не указаны критерии для удаления.");
    }

    $foundUsersToDelete = findUsers($userData, $nameToDelete, $dateToDelete);
    if (empty($foundUsersToDelete)) {
        return handleError("Ни один пользователь не найден.");
    }
    echo "Найденные пользователи для удаления:" . PHP_EOL;
    foreach ($foundUsersToDelete as $foundUser) {
        echo "- $foundUser[0]" . PHP_EOL;
    }
    $confirmation = readline("Вы уверены, что хотите удалить найденных пользователей? (y/n): ");
    if ($confirmation === 'y') {
        foreach ($foundUsersToDelete as $userDataItem) {
            unset($userData[array_search($userDataItem, $foundUsersToDelete)]);
        }
        // Записываем измененные данные в файл
        writeUserDataToFile($address, $userData);
        $content .= "Пользователи удалены." . PHP_EOL;
    } else {
        return handleError("Удаление пользователей отменено.");
    }
    return $content;
}
