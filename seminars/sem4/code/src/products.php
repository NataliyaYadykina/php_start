<?php

// Задание 2
// Есть абстрактный товар.
// Есть цифровой товар, штучный физический товар и товар на вес.
// У каждого есть метод подсчёта финальной стоимости.
// У цифрового товара стоимость постоянная и дешевле штучного товара в два
// раза, у штучного товара обычная стоимость, у весового – в зависимости от
// продаваемого количества в килограммах. У всех формируется в конечном
// итоге доход с продаж.
// Что можно вынести в абстрактный класс, наследование?

interface IProduct
{
    public function getFinalPrice(): float;
}

abstract class Product implements IProduct
{
    protected string $name;
    protected float $price;

    public function __construct(string $name, float $price)
    {
        $this->name = $name;
        $this->price = $price;
    }

    // abstract function getFinalPrice(): float;
}

class DiscreteProduct extends Product
{
    protected int $count;

    public function __construct(string $name, float $price, int $count)
    {
        parent::__construct($name, $price);
        $this->count = $count;
    }

    function getFinalPrice(): float
    {
        return $this->price * $this->count;
    }
}

class DigitalProduct extends DiscreteProduct
{
    protected string $url;
    protected int $downloaded = 0;

    public function __construct(string $name, float $price, int $count, string $url)
    {
        parent::__construct($name, $price, $count);
        $this->url = $url;
    }

    function getFinalPrice(): float
    {
        return $this->count * $this->price * 0.5;
    }
}

class WeightProduct extends Product
{
    protected float $weight;

    public function __construct(string $name, float $price, float $weight)
    {
        parent::__construct($name, $price);
        $this->weight = $weight;
    }

    function getFinalPrice(): float
    {
        return $this->price * $this->weight;
    }
}
