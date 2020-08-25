<?php

declare(strict_types=1);

namespace App\Repository;


use App\Entity\Cart;
use App\Entity\Catalog;
use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

final class CatalogRepository
{
    /**
     * @var ServiceEntityRepositoryInterface
     */
    private $repository;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->repository = $entityManager->getRepository(Cart::class);
        $this->entityManager = $entityManager;
    }

    public function addProduct(Catalog $catalog, Product $product)
    {
        $catalog->addProduct($product);
        $this->entityManager->flush();
    }

    public function removeProduct(Catalog $catalog, Product $product)
    {
        $catalog->removeProduct($product);
        $this->entityManager->flush();
    }
}