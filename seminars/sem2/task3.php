<?php

// Задание 3
// В функцию передается строка скобок. Например:
// "()()(())"
// Надо на выходе показать, корректна ли последовательность. 
// Некорректные последовательности
// ")("
// "())("

function checkBrackets($str)
{
    $stack = [];
    $brackets = [
        ')' => '(',
        ']' => '[',
        '}' => '{'
    ];

    foreach (str_split($str) as $char) {
        if (in_array($char, array_values($brackets))) {
            $stack[] = $char;
        } elseif (in_array($char, array_keys($brackets))) {
            if (empty($stack) || $brackets[$char] !== array_pop($stack)) {
                return false;
            }
        }
    }

    return empty($stack);
}

$str1 = "()()(())";

if (checkBrackets($str1)) {
    echo "Строка '$str1' корректна." . PHP_EOL;
} else {
    echo "Строка '$str1' некорректна." . PHP_EOL;
}

$str2 = ")(";

if (checkBrackets($str2)) {
    echo "Строка '$str2' корректна." . PHP_EOL;
} else {
    echo "Строка '$str2' некорректна." . PHP_EOL;
}


// variant 2

function checkBrackets2($str)
{
    $count = 0;
    for ($i = 0; $i < strlen($str); $i++) {
        if ($str[$i] === '(') {
            $count++;
        } else if ($str[$i] === ')') {
            $count--;
        }
        if ($count < 0) {
            return false;
        }
    }
    return $count === 0;
}

$str1 = "()()(())";

if (checkBrackets2($str1)) {
    echo "Строка '$str1' корректна." . PHP_EOL;
} else {
    echo "Строка '$str1' некорректна." . PHP_EOL;
}

$str2 = ")(";

echo checkBrackets2($str2) ? "Ok" : "Err" . PHP_EOL;
