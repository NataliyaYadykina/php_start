<?php

echo "Example 1\r\n";

$counter = 0;

function incrementCounter()
{
    global $counter;
    $counter++;
}


echo "Example 2\r\n";

$counter = 0;
function incrementCounter2(int $counter): int
{
    return $counter++;
}
echo $counter;
incrementCounter2($counter);
echo $counter; // значение никак не изменилось


echo "Example 3\r\n";

$counter = 0;
function incrementCounter3(int &$counter): int
{
    $counter++;
    return $counter;
}

echo $counter;
incrementCounter3($counter);
echo $counter;
