<?php

// switch (выражение) {
//     case значение1:
//         // действия, выполняемые при совпадении со значением1
//         break;
//     case значение2:
//         // действия, выполняемые при совпадении со значением2
//         break;
//     ...
//     default:
//         // действия, выполняемые при отсутствии совпадений
//         break;
// } 


echo "Example 1\r\n";

$product = "Burger";

switch ($product) {
    case "HotDog":
        echo "Выбран Хот-Дог\r\n";
        break;
    case "Cola":
        echo "Выбрана кола\r\n";
        break;
    case "Burger":
        echo "Выбран бургер\r\n";
        break;
    default:
        echo "Продукт неизвестен\r\n";
        break;
}
