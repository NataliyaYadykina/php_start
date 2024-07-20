<?php

// match (выражение) {
//     значение1 => выражение1,
//     значение2 => выражение2,
//     ...
//     default => выражение_по_умолчанию,
// }


echo "Example 1\r\n";

$value = "Burger";

$result = match ($value) {
    "HotDog" => "Выбран Хот-Дог\r\n",
    "Cola" => "Выбрана кола\r\n",
    "Burger" => "Выбран бургер\r\n",
    default => "Продукт неизвестен\r\n",
};

echo $result;
