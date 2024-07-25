<?php

// 1. Придумайте класс, который описывает любую сущность из предметной области библиотеки:
// книга, шкаф, комната и т.п.
// 2. Опишите свойства классов из п.1 (состояние).
// 3. Опишите поведение классов из п.1 (методы).
// 4. Придумайте наследников классов из п.1. Чем они будут отличаться?
// 5. Создайте структуру классов ведения книжной номенклатуры.
// — Есть абстрактная книга.
// — Есть цифровая книга, бумажная книга.
// — У каждой книги есть метод получения на руки.
// У цифровой книги надо вернуть ссылку на скачивание, а у физической – адрес библиотеки,
// где ее можно получить. У всех книг формируется в конечном итоге статистика по кол-ву прочтений.
// Что можно вынести в абстрактный класс, а что надо унаследовать?

class Library
{
    protected int $libraryId;
    protected string $name;
    protected string $address;
    protected array $rooms = [];

    public function __construct(int $libraryId, string $name, string $address)
    {
        $this->libraryId = $libraryId;
        $this->name = $name;
        $this->address = $address;
    }

    public function getLibraryId(): int
    {
        return $this->libraryId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function addRoom(Room $room): void
    {
        $this->rooms[] = $room;
    }

    public function showLibrary(): void
    {
        echo "Library ID: " . $this->libraryId . ", Name: " . $this->name . ", Address: " . $this->address . PHP_EOL;
    }

    public function showRooms(): void
    {
        echo "Комнаты библиотеки:" . PHP_EOL;
        foreach ($this->rooms as $room) {
            echo "Room ID: " . $room->getRoomId() . ", Name: " . $room->getName() . PHP_EOL;
        }
    }
}

class Room
{
    protected int $roomId;
    protected string $name;
    protected Library $library;
    protected array $shelfs = [];

    public function __construct(int $roomId, string $name, Library $library)
    {
        $this->roomId = $roomId;
        $this->name = $name;
        $this->library = $library;
    }

    public function getRoomId(): int
    {
        return $this->roomId;
    }

    public function getLibrary(): Library
    {
        return $this->library;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function addShelf(BookShelf $shelf): void
    {
        $this->shelfs[] = $shelf;
    }

    public function showShelfs(): void
    {
        echo "Шкафы комнаты: " . $this->roomId . PHP_EOL;
        foreach ($this->shelfs as $shelf) {
            echo "Shelf ID: " . $shelf->getShelfId() . ", Categories: " . $shelf->getCategory() . PHP_EOL;
        }
    }
}

class BookShelf
{
    protected int $shelfId;
    protected array $categories = [];
    protected Room $room;
    protected array $books = [];

    public function __construct(int $shelfId, Room $room)
    {
        $this->shelfId = $shelfId;
        $this->room = $room;
    }

    public function getShelfId(): int
    {
        return $this->shelfId;
    }

    public function getRoom(): Room
    {
        return $this->room;
    }

    public function setCategory(string $category): void
    {
        $this->categories[] = $category;
    }

    public function getCategory(): string
    {
        return implode(', ', $this->categories);
    }

    public function addBook(Book $book): void
    {
        $this->books[] = $book;
    }

    public function showBooks(): void
    {
        echo "Книги в шкафу $this->shelfId (комната #{$this->getRoom()->getRoomId()}, библиотека #{$this->getRoom()->getLibrary()->getLibraryId()}): {$this->getCountBooks()} шт.:" .  PHP_EOL;
        if (!empty($this->books)) {
            foreach ($this->books as $book) {
                echo "ID: " . $book->getId() . ", Title: " . $book->getTitle() . PHP_EOL;
            }
        } else {
            echo "В шкафу нет книг." . PHP_EOL;
        }
    }

    public function getCountBooks(): int
    {
        return count($this->books);
    }
}

abstract class Book
{
    protected int $id;
    protected string $title;
    protected array $authors;
    protected int $pages;
    protected int $readCount = 0;
    protected Library $library;

    public function __construct(int $id, string $title, array $authors, int $pages, Library $library)
    {
        $this->id = $id;
        $this->title = $title;
        $this->authors = $authors;
        $this->pages = $pages;
        $this->library = $library;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function showBook(): void
    {
        echo "ID: " . $this->id . ", Title: " . $this->title . ", Authors: " . implode(', ', $this->authors) . ", Pages: " . $this->pages . PHP_EOL;
        if ($this instanceof DigitalBook) {
            echo "Link: " . $this->getDownloadLink() . PHP_EOL;
        }
        if ($this instanceof PhysicalBook) {
            echo "Address: " . $this->getLibraryAddress() . PHP_EOL;
        }
    }

    abstract function takeBook(): void;

    abstract function returnBook(): void;

    public function getReadCount(): int
    {
        return $this->readCount;
    }

    public function incrementReadCount(): void
    {
        $this->readCount++;
    }
}

class DigitalBook extends Book
{
    protected string $link;
    protected string $text;
    protected int $downloads = 0;
    protected bool $startReading = false;
    protected int $countReadingNow = 0;

    public function __construct(int $id, string $title, array $authors, int $pages, Library $library, string $link, string $text)
    {
        parent::__construct($id, $title, $authors, $pages, $library);
        $this->link = $link;
        $this->text = $text;
    }

    public function getDownloadLink(): string
    {
        return $this->link;
    }

    public function download(): void
    {
        echo "Downloading..." . PHP_EOL;
        $this->downloads++;
    }

    public function getStatistics(): array
    {
        return [
            'title' => $this->title,
            'authors' => $this->authors,
            'pages' => $this->pages,
            'downloads' => $this->downloads,
            'total_read' => $this->readCount,
            'current_reading' => $this->countReadingNow
        ];
    }

    public function showStatistics(): void
    {
        $stats = $this->getStatistics();
        echo "Digital Book statistics:\n";
        echo "Title: {$stats['title']}\n";
        echo "Authors: " . implode(', ', $stats['authors']) . "\n";
        echo "Pages: {$stats['pages']}\n";
        echo "Downloads: {$stats['downloads']}\n";
        echo "Total read: {$stats['total_read']}\n";
        echo "Current reading: {$stats['current_reading']}\n";
    }

    public function takeBook(): void
    {
        $this->startReading = true;
        $this->countReadingNow++;
        echo "Электронная книга с ID {$this->id} - {$this->title} - начато чтение.\n";
    }

    public function returnBook(): void
    {
        $this->incrementReadCount();
        $this->startReading = false;
        $this->countReadingNow--;
        echo "Электронная книга с ID {$this->id} - {$this->title} - прочитана.\n";
    }
}

class PhysicalBook extends Book
{
    protected int $shelfId;
    protected bool $onHand = false;

    public function getLibraryAddress(): string
    {
        return $this->library->getAddress();
    }

    public function placeInShelf(BookShelf $shelf): void
    {
        $this->shelfId = $shelf->getShelfId();
        $shelf->addBook($this);
    }

    public function takeBook(): void
    {
        $this->incrementReadCount();
        $this->onHand = true;
        echo "Книга с ID {$this->id} - {$this->title} - взята на руки.\n";
    }

    public function returnBook(): void
    {
        $this->onHand = false;
        echo "Книга с ID {$this->id} - {$this->title} - возвращена в библиотеку.\n";
    }
}

$library = new Library(1, 'Библиотека "Арктика"', 'ул. Красная, д. 12');

$library->showLibrary();

$rooms = [];
for ($i = 1; $i < 4; $i++) {
    $rooms[] = new Room($i, "Комната $i", $library);
}

foreach ($rooms as $key => $value) {
    $room = $rooms[$key];
    $library->addRoom($room);
}

$library->showRooms();

$shelfs = [];

for ($i = 1; $i < 6; $i++) {
    $shelfs[] = new BookShelf($i, $rooms[array_rand($rooms)]);
}

foreach ($shelfs as $key => $value) {
    $shelf = $shelfs[$key];
    $rooms[array_rand($rooms)]->addShelf($shelf);
}

foreach ($rooms as $room) {
    $room->showShelfs();
}

$books = [];

for ($i = 1; $i < 5; $i++) {
    $books[] = new DigitalBook($i, 'Книга ' . $i, ['Автор ' . $i], rand(100, 500), $library, 'https://example.com/book' . $i, 'Описание книги...');
    $books[] = new PhysicalBook($i + 100, 'Книга ' . ($i + 100), ['Автор ' . ($i + 100)], rand(100, 500), $library);
    $books[] = new PhysicalBook($i + 200, 'Книга ' . ($i + 200), ['Автор ' . ($i + 200)], rand(100, 500), $library);
}

foreach ($books as $book) {
    $book->showBook();
    if ($book instanceof PhysicalBook) {
        $book->placeInShelf($shelfs[array_rand($shelfs)]);
    }
}

foreach ($shelfs as $shelf) {
    $shelf->showBooks();
}

$books[1]->takeBook();
$books[1]->returnBook();
echo "Книга ID {$books[1]->getId()} прочитана {$books[1]->getReadCount()} раз." . PHP_EOL;
$books[1]->takeBook();
$books[1]->returnBook();
echo "Книга ID {$books[1]->getId()} прочитана {$books[1]->getReadCount()} раз." . PHP_EOL;

$books[0]->showStatistics();
$books[0]->takeBook();
$books[0]->download();
$books[0]->showStatistics();
$books[0]->returnBook();
$books[0]->showStatistics();
