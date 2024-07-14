<?php
echo "Привет, GeekBrains, from Nataliya Yadykina! ;)\n";
$a = 5;
$b = '05';
// true, потому что '05' будет приведено к числу 5
var_dump($a == $b);
// int(123), нулевой символ игнорируется при приведении
var_dump((int)'012345');
// false, потому что строгое сравнение разных типов данных
var_dump((float)123.0 === (int)123.0);
// php7.4: true, потому что строка, начинающаяся с буквы, при приведении к числу становится 0
// php8.2: false, т.к. приведение строки к числу становится более строгим
var_dump(0 == 'hello, world');
echo "Task 4\n";
$num1 = 1;
$num2 = 2;
echo "Before: num1 = $num1, num2 = $num2\n";
$num1 = $num1 ^ $num2; // $num1 теперь равно 3 (побитовое XOR)
$num2 = $num1 ^ $num2; // $num2 теперь равно 1 (побитовое XOR)
$num1 = $num1 ^ $num2; // $num1 теперь равно 2 (побитовое XOR)
echo "After: num1 = $num1, num2 = $num2\n";
?>

// docker run --rm -v ${pwd}/php-cli/:/cli php:8.2-cli php /cli/start.php (Windows)
// docker run --rm -v $(pwd)/php-cli/:/cli php:8.2-cli php /cli/start.php (Linux/Mac)
