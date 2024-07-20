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

$summ = 0; // итоговая сумма баллов

foreach ($students as $student) {
    $summ += $student['score'];
}

echo 'Средний балл: ' . $summ / count($students) . "\r\n";
