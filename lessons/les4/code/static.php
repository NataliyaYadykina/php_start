<?php

class Student
{
    public string $name;
    public int $age;
    public static float $discount = 0.5;

    function __construct(string $name, int $age)
    {
        $this->name = $name;
        $this->age = $age;
    }

    function sayHello(): string
    {
        return "Hello, my name is " . $this->name . ". I am " . $this->age . " years old." . PHP_EOL;
    }

    public static function getDiscount(float $mealPrice): float
    {
        return $mealPrice * Student::$discount;
    }
}

$student1 = new Student("John Doe", 25);
echo $student1->sayHello(); // Output: Hello, my name is John Doe. I am 25 years old.

$student2 = new Student("Jane Smith", 30);
echo $student2->sayHello(); // Output: Hello, my name is Jane Smith. I am 30 years old.
echo Student::$discount . PHP_EOL; // Output: 0.5

$students = [
    new Student("Alice Johnson", 20),
    new Student("Bob Brown", 22),
    new Student("Charlie Davis", 25)
];

foreach ($students as $student) {
    echo $student->sayHello();
}

$mealPrice = 100.0;
echo "Discounted meal price: " . Student::getDiscount($mealPrice) . PHP_EOL; // Output: Discounted meal price: 50.0
