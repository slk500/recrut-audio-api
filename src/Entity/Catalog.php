<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Catalog
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

    public function getId(): int
    {
        return $this->id;
    }

    public function add(Product $product): void
    {
        $this->products[] = $product;
    }

    public function remove(Product $product): void
    {
        if (!$this->products->contains($product)) {
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
}