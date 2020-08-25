<?php


namespace App\Repository;


use App\Dto\ProductDto;
use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

class ProductRepository
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
        $this->repository = $entityManager->getRepository(Product::class);
        $this->entityManager = $entityManager;
    }

    public function add(Product $product)
    {
        $this->entityManager->persist($product);
        $this->entityManager->flush();
    }

    public function update(Product $product, ProductDto $productDto)
    {
        $product->setName($productDto->name);
        $product->setPrice($productDto->price);

        $this->entityManager->flush();
    }

}