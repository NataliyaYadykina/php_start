<?php

echo "Example 1\r\n";

$isRed = true;
if ($isRed) {
    echo "Red\r\n";
}


echo "Example 2\r\n";

$a = 5;
$b = 10;
if ($a < $b) {
    echo "a меньше, чем b\r\n";
}


echo "Example 3\r\n";

$a = 5;
$b = "5";
if ($a == $b) {
    echo "a идентично b\r\n";
}

if ($a !== $b) {
    echo "a не идентично b или имеет другой тип\r\n";
}


echo "Example 4\r\n";

$a = 5;
$b = 10;
if ($a > 0 && $b > 0) {
    echo "Оба числа положительные\r\n";
}


echo "Example 5\r\n";

$a = -5;
$b = 10;
if ($a < 0 or $b < 0) {
    echo "Как минимум одно из чисел - отрицательное\r\n";
}


echo "Example 6\r\n";

$a = 5;
if (!($a == 10)) {
    echo "a не равно 10\r\n";
}
