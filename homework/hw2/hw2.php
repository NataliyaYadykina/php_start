<?php

// 1. Реализовать основные 4 арифметические операции в виде функции с двумя параметрами –
// два параметра - это числа. Обязательно использовать оператор return.

echo "___Task 1___" . PHP_EOL;

$a = 5;
$b = 3;

function add($a, $b)
{
    return $a + $b;
}

echo "$a + $b = " . add($a, $b) . PHP_EOL;

function subtract($a, $b)
{
    return $a - $b;
}

echo "$a - $b = " . subtract($a, $b) . PHP_EOL;

function multiply($a, $b)
{
    return $a * $b;
}

echo "$a * $b = " . multiply($a, $b) . PHP_EOL;

// function divide($a, $b)
// {
//     if ($b !== 0) {
//         return $a / $b;
//     }
//     return "Деление на ноль невозможно!";
// }

function divide($a, $b)
{
    return ($b !== 0) ? $a / $b : "Деление на ноль невозможно!";
}

echo "$a / $b = " . divide($a, $b) . PHP_EOL;
$a = 0;
echo "$a / $b = " . divide($a, $b) . PHP_EOL;
$a = 5;
$b = 0;
echo "$a / $b = " . divide($a, $b) . PHP_EOL;


// 2. Реализовать функцию с тремя параметрами: function mathOperation($arg1, $arg2, $operation),
// где $arg1, $arg2 – значения аргументов, $operation – строка с названием операции.
// В зависимости от переданного значения операции выполнить одну из арифметических операций
// (использовать функции из пункта 3) и вернуть полученное значение (использовать switch).

echo "___Task 2___" . PHP_EOL;

// function mathOperation($arg1, $arg2, $operation)
// {
//     if ($operation === "add") {
//         return add($arg1, $arg2);
//     } else if ($operation === "subtract") {
//         return subtract($arg1, $arg2);
//     } else if ($operation === "multiply") {
//         return multiply($arg1, $arg2);
//     } else if ($operation === "divide") {
//         return divide($arg1, $arg2);
//     } else {
//         return "Неизвестная операция";
//     }
// }

function mathOperation($arg1, $arg2, $operation)
{
    return match ($operation) {
        'add' => add($arg1, $arg2),
        'subtract' => subtract($arg1, $arg2),
        'multiply' => multiply($arg1, $arg2),
        'divide' => divide($arg1, $arg2),
        default => "Неизвестная операция"
    };
}

$a = 5;
$b = 3;

echo "$a + $b = " . mathOperation($a, $b, 'add') . PHP_EOL;
echo "$a - $b = " . mathOperation($a, $b, 'subtract') . PHP_EOL;
echo "$a * $b = " . mathOperation($a, $b, 'multiply') . PHP_EOL;
echo "$a / $b = " . mathOperation($a, $b, 'divide') . PHP_EOL;
echo mathOperation($a, $b, 'div') . PHP_EOL;


// 3. Объявить массив, в котором в качестве ключей будут использоваться названия областей,
// а в качестве значений – массивы с названиями городов из соответствующей области.
// Вывести в цикле значения массива, чтобы результат был таким:
// Московская область:Москва, Зеленоград, Клин
// Ленинградская область: Санкт-Петербург, Всеволожск, Павловск, Кронштадт
// Рязанская область … (названия городов можно найти на maps.yandex.ru).

echo "___Task 3___" . PHP_EOL;

$regions = [
    'Московская область' => ['Москва', 'Зеленоград', 'Клин'],
    'Ленинградская область' => ['Санкт-Петербург', 'Всеволожск', 'Павловск', 'Кронштадт'],
    'Рязанская область' => ['Санкт-Петербург', 'Всеволожск', 'Павловск', 'Кронштадт']
];

foreach ($regions as $region => $cities) {
    $result = "";
    $result .= "$region:";
    foreach ($cities as $city) {
        $result .= " $city,";
    }
    $result = mb_substr($result, 0, mb_strlen($result) - 1);
    echo $result . PHP_EOL;
}

// 4. Объявить массив, индексами которого являются буквы русского языка,
// а значениями – соответствующие латинские буквосочетания
// (‘а’=> ’a’, ‘б’ => ‘b’, ‘в’ => ‘v’, ‘г’ => ‘g’, …, ‘э’ => ‘e’, ‘ю’ => ‘yu’, ‘я’ => ‘ya’).
// Написать функцию транслитерации строк.

echo "___Task 4___" . PHP_EOL;


function transliterate($string)
{

    $alfabet = [
        'а' => 'a',
        'б' => 'b',
        'в' => 'v',
        'г' => 'g',
        'д' => 'd',
        'е' => 'e',
        'ё' => 'e',
        'ж' => 'zh',
        'з' => 'z',
        'и' => 'i',
        'й' => 'y',
        'к' => 'k',
        'л' => 'l',
        'м' => 'm',
        'н' => 'n',
        'о' => 'o',
        'п' => 'p',
        'р' => 'r',
        'с' => 's',
        'т' => 't',
        'у' => 'u',
        'ф' => 'f',
        'х' => 'h',
        'ц' => 'c',
        'ч' => 'ch',
        'ш' => 'sh',
        'щ' => 'sch',
        'ь' => '\'',
        'ы' => 'y',
        'ъ' => '\'',
        'э' => 'e',
        'ю' => 'yu',
        'я' => 'ya'
    ];

    $transliteratedString = '';
    $length = mb_strlen($string);

    for ($i = 0; $i < $length; $i++) {
        $char = mb_substr($string, $i, 1);

        // echo $transliteratedString . PHP_EOL;

        // Проверяем, является ли символ кириллической буквой
        if (isset($alfabet[mb_strtolower($char)])) {

            // Получаем транслитерацию символа
            $transliteratedChar = $alfabet[mb_strtolower($char)];

            // Если символ - заглавный, сохраняем его как заглавный
            // Если буква из нескольких символов, заглавный только первый символ, остальные - строчные
            if (mb_strtoupper($char) === $char) {
                $transliteratedString .= mb_strtoupper(mb_substr($transliteratedChar, 0, 1)) . mb_substr($transliteratedChar, 1);
            } else {
                // Если не заглавный, берем транслитерацию как есть
                $transliteratedString .= $transliteratedChar;
            }
        } else {
            // Если символ не кириллическая буква, добавляем его как есть
            $transliteratedString .= $char;
        }
    }

    return $transliteratedString;
}

$string = "прiВЕт, Шикарный уДивиТелЬныЙ Миr! 123";
$transliterated = transliterate($string);
echo $transliterated . PHP_EOL;


// 5. *С помощью рекурсии организовать функцию возведения числа в степень.
// Формат: function power($val, $pow), где $val – заданное число, $pow – степень.

echo "___Task 5___" . PHP_EOL;

function power($val, $pow)
{
    if ($pow == 0) {
        return 1;
    }
    return $val * power($val, $pow - 1);
}

$val = 2;
echo "$val в степени " . $val . " = " . power($val, $val) . PHP_EOL;
$pow = 3;
echo "$val в степени " . $pow . " = " . power($val, $pow) . PHP_EOL;


// 6. *Написать функцию, которая вычисляет текущее время и
// возвращает его в формате с правильными склонениями, например:
// 22 часа 15 минут
// 21 час 43 минуты.

echo "___Task 6___" . PHP_EOL;

function getDeclension($number, $titles)
{
    // Стандартные правила склонения для русского языка в зависимости от остатка от деления числа на 10.
    // Правила склонения для русского языка:
    // Единственное число:
    // Если число заканчивается на 1, то используется первая форма (например, "час", "минута").
    // Если число заканчивается на 2, 3, 4, то используется вторая форма (например, "часа", "минуты").
    // Если число заканчивается на 5, 6, 7, 8, 9, 0, то используется третья форма (например, "часов", "минут").
    // Множественное число (от 11 до 19 и числа, заканчивающиеся на 0, 5-9):
    // Всегда используется третья форма (например, "часов", "минут").
    // Массив $cases в функции представляет собой набор индексов,
    // соответствующих различным остаткам от деления числа на 10. Вот как они соотносятся:
    //     0 - соответствует остатку 0 от деления на 10 (третья форма, индекс 2 для массивов слов: $hour_titles и $minut_titles).
    //     1 - соответствует остатку 1 (первая форма, индекс 0 для массивов слов: $hour_titles и $minut_titles).
    //     2 - соответствует остатку 2 (вторая форма, индекс 1 для массивов слов: $hour_titles и $minut_titles).
    //     3 - соответствует остатку 3 (вторая форма, индекс 1 для массивов слов: $hour_titles и $minut_titles).
    //     4 - соответствует остатку 4 (вторая форма, индекс 1 для массивов слов: $hour_titles и $minut_titles).
    //     5 - соответствует остатку 5 и выше (для универсальности, так как форма одинакова для 5, 6, 7, 8, 9)  (третья форма, индекс 2 для массивов слов: $hour_titles и $minut_titles).
    $cases = [2, 0, 1, 1, 1, 2];

    // Выбираем индекс из значений массива $cases. В соответствии с ним будет выбрана верная форма слова в функции formatTime()
    // min($number % 10, 5) - это индекс самого массива $cases
    return $number . ' ' . $titles[($number % 100 > 4 && $number % 100 < 20) ? 2 : $cases[min($number % 10, 5)]];
}

function formatTime()
{
    $hours = date('G');
    $minutes = date('i');
    $hour_titles = ['час', 'часа', 'часов'];
    $minut_titles = ['минута', 'минуты', 'минут'];

    // Определяем склонение для часов
    $hoursStr = getDeclension($hours, $hour_titles);

    // Определяем склонение для минут
    $minutesStr = getDeclension($minutes, $minut_titles);

    return "$hoursStr $minutesStr";
}

echo formatTime() . PHP_EOL;
