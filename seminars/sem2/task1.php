<?php

// Задание 1
// Даны два упорядоченных массива, например,
// [1, 4, 6, 6, 8]
// [2, 5, 7, 9]
// Нужно написать логику, которая сольёт массивы в один упорядоченный по
// возрастанию значений
// [1, 2, 4, 5, 6, 6, 7, 8, 9]
// Важно учесть граничные условия:
// - элементы могут повторяться
// - массивы могут быть произвольной длины

$arr1 = [1, 4, 6, 6, 8];
$arr2 = [2, 5, 7, 9];

$count1 = 0;
$count2 = 0;

$result = [];

while ($count1 < count($arr1) && $count2 < count($arr2)) {
    if ($arr1[$count1] < $arr2[$count2]) {
        $result[] = $arr1[$count1];
        $count1++;
    } else {
        $result[] = $arr2[$count2];
        $count2++;
    }
}

if ($count1 < count($arr1)) {
    for (; $count1 < count($arr1); $count1++) {
        $result[] = $arr1[$count1];
    }
}

if ($count2 < count($arr2)) {
    for (; $count2 < count($arr2); $count2++) {
        $result[] = $arr2[$count2];
    }
}

print_r($result);
