<?php

// Задание 2
// Написать функцию, которая принимает на вход число, а затем возвращает
// булевский ответ – простое ли оно.
// Для всех i от 1 до 10 {
//     проверить, делится ли число i на какое-либо из чисел до него
//     если делится, то это i не подходит, берём следующее
//     если не делится, то i - простое число
//    }

function isSimple($num)
{
    for ($i = 2; $i <= sqrt($num); $i++) {
        if ($num % $i == 0) {
            echo "skip: " . $num . PHP_EOL;
            break;
        }
    }
    return "yes: $num";
}

// Тесты
echo isSimple(1) . PHP_EOL; // false
echo isSimple(2) . PHP_EOL; // true
echo isSimple(4) . PHP_EOL; // false
echo isSimple(7) . PHP_EOL; // true
echo isSimple(10) . PHP_EOL; // false