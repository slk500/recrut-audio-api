<?php

declare(strict_types=1);

namespace App\Dto;


use App\Entity\Product;

final class ProductDto
{
    public string $name;
    public int $price;

    public function toEntity(): Product
    {
        return new Product($this->name, $this->price);
    }

    public static function fromEntity(Product $product)
    {
        $self = new self();

        $self->name = $product->getName();
        $self->price = $product->getPrice();

        return $self;
    }
}