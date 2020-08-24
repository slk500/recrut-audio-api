<?php


namespace App\Dto;


use App\Entity\Product;

class ProductDto
{
    public string $name;
    public int $price;

    public function toEntity(): Product
    {
        return new Product($this->name, $this->price);
    }
}