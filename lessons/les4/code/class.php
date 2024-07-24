<?php


// Person
abstract class Person
{
    protected string $name;
    protected array $access = [];
    protected static string $writableName = 'Person';

    public function __construct(string $name, array $access = [])
    {
        $this->name = $name;
        $this->access = $access;
    }

    public final function checkAccess(string $room)
    {
        return in_array($room, $this->access);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        // if ($this->validateName($name)) {
        $this->name = $name;
        // }
    }

    abstract public function goToLunch(): string;

    public function whoAmI(): string
    {
        return 'I am a ' . static::$writableName . PHP_EOL;
    }
}


// Teacher
class Teacher extends Person
{
    protected static string $writableName = 'Teacher';

    public function __construct(string $name)
    {
        parent::__construct($name, ['classroom', 'teachersroom']);
    }

    public function guideLecture() {}

    public function goToLunch(): string
    {
        return "Going to lunch... Teacher";
    }
}


// Student
class Student extends Person
{
    protected static string $writableName = 'Student';

    public function __construct(string $name)
    {
        parent::__construct($name, ['classroom']);
    }

    public function goToLunch(): string
    {
        return "Going to lunch... Student";
    }
}

// Usage
$teacher = new Teacher('John Doe');
$student = new Student('Michael');

// var_dump($student->checkAccess('teachersroom')); // false
var_dump($teacher->checkAccess('teachersroom')); // true

$persons = [
    new Teacher('John Doe'),
    new Student('Michael'),
    new Person('Jane Doe', ['classroom', 'teachersroom']) // Access to classroom and teachersroom
    // new Object(); // подсунули не то
];

foreach ($persons as $person) {
    if ($person instanceof Person) {
        echo $person->getName() . ': ' . $person->goToLunch() . PHP_EOL;
        echo $person->whoAmI();
    }
}
