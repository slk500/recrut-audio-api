<?php

declare(strict_types=1);

namespace App\Entity;


use App\ValueObject\Money;

class Cart
{
    /**
     * @var Product[]
     */
    private array $products = [];

    public function add(Product $product): void
    {
        if(count($this->products) === 3) {
            throw new \Exception('cart can contain a max. of 3 products');
        }

        $this->products[] = $product;
    }

    public function remove(Product $product): void
    {
        $this->products = array_filter($this->products,
            fn(Product $productInCatalog) => ($product != $productInCatalog)
        );
    }

    /**
     * @return Product[]
     */
    public function getProducts(): array
    {
        return $this->products;
    }

    public function getProductsPrice()
    {
        $prices = array_map(fn(Product $product) => $product->getPrice(), $this->getProducts());

        return new Money(
            array_reduce($prices,
                fn($carry, $element) => $carry + $element->getQuantity())
        );
    }
}