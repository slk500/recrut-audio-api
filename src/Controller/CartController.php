<?php


namespace App\Controller;


use App\Entity\Cart;
use Symfony\Component\Routing\Annotation\Route;

class CartController
{
    /**
     * @Route("carts/{id}", methods={"GET"})
     */
    public function show(Cart $cart): Cart
    {
        return $cart;
    }
}