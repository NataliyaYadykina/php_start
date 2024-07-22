<?php

// Поиск именинников на сегодня и ближайшие дни
function findBirthdaysUpcoming($userData, $countDaysToBirthdays)
{
    $upcomingBirthdays = [];

    foreach ($userData as $line) {
        $name = trim($line[0]);
        $birthdate = trim($line[1]);
        // echo "$name - $birthdate" . PHP_EOL;

        $birthdayParts = explode('-', $birthdate);
        $birthdayDay = $birthdayParts[0];
        $birthdayMonth = $birthdayParts[1];
        // echo "$birthdayDay - $birthdayMonth" . PHP_EOL;

        $birthdayFormatted = sprintf('%02d-%02d', $birthdayDay, $birthdayMonth);
        $daysToBirthday = calculateDaysToBirthday($birthdayDay, $birthdayMonth);

        if ($daysToBirthday <= $countDaysToBirthdays) {
            $upcomingBirthdays[$name] = $birthdayFormatted;
        }
    }

    return $upcomingBirthdays;
}

// Подсчет количества дней до дня рождения
function calculateDaysToBirthday($birthdayDay, $birthdayMonth)
{
    $birthdateTimestamp = strtotime("$birthdayDay-$birthdayMonth-" . date('Y'));
    $currentTimestamp = time();

    if ($birthdateTimestamp >= $currentTimestamp) {
        return ceil(($birthdateTimestamp - $currentTimestamp) / (60 * 60 * 24));
    } else {
        return ceil((($birthdateTimestamp + 31536000) - $currentTimestamp) / (60 * 60 * 24));
    }
}

// Генерация сообщения о днях рождениях
function generateBirthdayMessage($todayBirthdays, $upcomingBirthdays, $countDaysToBirthdays)
{
    $contents = 'Именинники сегодня:' . PHP_EOL;

    if (!empty($todayBirthdays)) {
        foreach ($todayBirthdays as $person) {
            $name = $person[0];
            $date = $person[1];
            $contents .= "$name" . PHP_EOL;
        }
    } else {
        $contents .= "Сегодня нет именинников." . PHP_EOL;
        if (!empty($upcomingBirthdays)) {
            $contents .= "Ближайшие дни рождения на следующие $countDaysToBirthdays " . get_word($countDaysToBirthdays, 'дней', 'день', 'дня') . ":" . PHP_EOL;
            foreach ($upcomingBirthdays as $name => $date) {
                $contents .= "$name: $date" . PHP_EOL;
            }
        } else {
            $contents .= "Нет именинников в ближайшие $countDaysToBirthdays " . get_word($countDaysToBirthdays, 'дней', 'день', 'дня') . "." . PHP_EOL;
        }
    }

    return $contents;
}

// Основная функция получения и вывода информации о днях рождения на сегодня или ближайшие дни
function getBirthdaysToday(array $config)
{
    $currentDate = date('d-m');
    $address = $config['storage']['address'];
    $countDaysToBirthdays = 10;

    $userData = readUserDataFromFile($address);

    $todayBirthdays = findUsers($userData, '', $currentDate);

    $upcomingBirthdays = findBirthdaysUpcoming($userData, $countDaysToBirthdays);

    if (empty($userData)) {
        return handleError("Файл не существует");
    }

    return generateBirthdayMessage($todayBirthdays, $upcomingBirthdays, $countDaysToBirthdays);
}
