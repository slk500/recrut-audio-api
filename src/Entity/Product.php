<?php

declare(strict_types=1);

namespace App\Entity;


use App\ValueObject\Money;

class Product
{
    private string $name;

    private Money $price;

    public function __construct(string $name, Money $price)
    {
        $this->name = $name;
        $this->price = $price;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): Money
    {
        return $this->price;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setPrice(Money $price): void
    {
        $this->price = $price;
    }
}