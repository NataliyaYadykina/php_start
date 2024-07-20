<?php

echo "Example 1\r\n";

$array = array(1, 2, 3);

echo "$array[0]\r\n";
echo "$array[1]\r\n";
echo "$array[2]\r\n";


echo "Example 2\r\n";

$array = ['foo', 'bar', 'baz'];

echo "$array[0]\r\n";
echo "$array[1]\r\n";
echo "$array[2]\r\n";


echo "Example 3\r\n";

$student = array(
    'name' => 'Иван',
    'age' => 18,
    'email' => 'john@example.com'
);

echo $student['name'] . "\r\n"; // выводит 'Иван'


echo "Example 4\r\n";

$array = array(
    array(1, 2, 3),
    array(4, 5, 6)
);

echo $array[0][1] . "\r\n"; // выводит 2
