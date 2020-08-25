<?php


namespace App\Controller;


use App\Entity\Cart;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;

class CartController
{
    /**
     * @Route("carts", methods={"POST"})
     */
    public function create(EntityManagerInterface $entityManager): Cart
    {
        $cart = new Cart();
        $entityManager->persist($cart);
        $entityManager->flush();

        return $cart;
    }

    /**
     * @Route("carts/{cart}/products/{product}", methods={"PATCH"})
     */
    public function addProduct(Cart $cart, Product $product, EntityManagerInterface $entityManager): void
    {
        $cart->addProduct($product);
        $entityManager->flush();
    }

    /**
     * @Route("carts/{cart}/products/{product}", methods={"DELETE"})
     */
    public function removeProduct(Cart $cart, Product $product, EntityManagerInterface $entityManager): void
    {
        $cart->removeProduct($product);
        $entityManager->flush();
    }

    /**
     * @Route("carts/{id}", methods={"GET"})
     */
    public function show(Cart $cart): Cart
    {
        return $cart;
    }
}