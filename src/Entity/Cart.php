<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Cart
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @var Collection&Product[]
     * @ORM\ManyToMany(targetEntity="App\Entity\Product")
     */
    private Collection $products;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    public function add(Product $product): void
    {
        if(count($this->products) === 3) {
            throw new \Exception('cart can contain a max. of 3 products');
        }

        $this->products[] = $product;
    }

    public function remove(Product $product): void
    {
        if(!$this->products->contains($product)){
            return;
        }

        $this->products->removeElement($product);
    }

    /**
     * @return Collection&Product[]
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getProductsPrice()
    {
        return array_reduce($this->getProducts()->toArray(),
                fn($carry, $element) => $carry + $element->getPrice(),0);
    }
}