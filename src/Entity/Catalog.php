<?php

declare(strict_types=1);

namespace App\Entity;


class Catalog
{
    private int $id;

    /**
     * @var Product[]
     */
    private array $products;

    public function __construct(Product ...$products)
    {
        $this->products = $products;
    }

    public function add(Product $product): void
    {
        $this->products[] = $product;
    }

    public function remove(Product $product): void
    {
        $this->products = array_filter($this->products,
            fn(Product $productInCatalog) => ($product != $productInCatalog)
        );
    }

    public function isEmpty(): bool
    {
        return empty($this->products);
    }
}