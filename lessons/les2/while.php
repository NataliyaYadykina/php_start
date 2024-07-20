<?php

echo "Example 1\r\n";

$students = [
    [
        'name' => 'Иван',
        'score' => 4.5
    ],
    [
        'name' => 'Мария',
        'score' => 5
    ],
    [
        'name' => 'Петр',
        'score' => 3.7
    ]
];

$counter = 0; // начинаем самого первого элемента
$summ = 0; // итоговая сумма баллов

while ($counter < count($students)) {
    $summ += $students[$counter]['score'];
    $counter++;
}

echo 'Средний балл: ' . $summ / count($students) . "\r\n";
