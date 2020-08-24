<?php


namespace App\Controller;


use App\Entity\Cart;
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
     * @Route("carts/{id}", methods={"GET"})
     */
    public function show(Cart $cart): Cart
    {
        return $cart;
    }


}