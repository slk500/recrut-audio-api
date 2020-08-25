<?php


namespace App\Repository;


use App\Entity\Cart;
use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

final class CartRepository
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

    public function add(): Cart
    {
        $cart = new Cart();
        $this->entityManager->persist($cart);
        $this->entityManager->flush();

        return $cart;
    }

    public function addProduct(Cart $cart, Product $product)
    {
        $cart->addProduct($product);
        $this->entityManager->flush();
    }

    public function removeProduct(Cart $cart, Product $product)
    {
        $cart->removeProduct($product);
        $this->entityManager->flush();
    }
}