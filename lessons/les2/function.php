<?php

echo "Example 1\r\n";

$studentsArray = [
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

function getAverageScore(array $studentsArray): float
{
    $summ = 0; // итоговая сумма баллов

    foreach ($studentsArray as $student) {
        $summ += $student['score'];
    }

    return $summ / count($studentsArray);
}

echo getAverageScore($studentsArray) . "\r\n";
