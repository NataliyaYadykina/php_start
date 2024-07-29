<?php


abstract class AbstractBook
{

    protected string $title;

    protected string $isbn;

    protected array $authors;

    protected string $releaseDate;

    protected string $preview;

    abstract function recycleBook(): void;

    abstract function addBook(): void;

    abstract function getBook(): AbstractBook;

    abstract function returnBook(AbstractBook $book): void;

}

$book = new Book();
$book->getBook()->returnBook($book);


class Book extends AbstractBook
{

    protected int $pageCount;

    public function getBook(): Book
    {

// логика учета

        return $this;

    }

    public function returnBook(AbstractBook $book): void
    {

// логика учета

    }

    public function recycleBook(): void
    {

// логика удаления

    }

    public function addBook(): void
    {

// логика добавления

    }

}

class DigitalBook extends AbstractBook
{

    private string $bookURL;

    public function getBook(): DigitalBook
    {

// логика учета

        $this->getURL();

// формируем страницу на скачивание

        return $this;

    }

    public function returnBook(AbstractBook $book): void
    {

// логика учета

    }

    public function getURL(): string
    {

        return $this->bookURL;

    }

    public function recycleBook(): void
    {

// логика удаления

    }

    public function addBook(): void
    {

// логика добавления

    }

}