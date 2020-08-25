<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Cart;
use App\Entity\Product;
use App\Repository\CartRepository;
use Symfony\Component\Routing\Annotation\Route;

final class CartController
{
    /**
     * @Route("carts", methods={"POST"})
     */
    public function create(CartRepository $cartRepository): void
    {
        $cartRepository->add();
    }

    /**
     * @Route("carts/{cart}/products/{product}", methods={"PATCH"})
     */
    public function addProduct(Cart $cart, Product $product, CartRepository $cartRepository): void
    {
        $cartRepository->addProduct($cart, $product);
    }

    /**
     * @Route("carts/{cart}/products/{product}", methods={"DELETE"})
     */
    public function removeProduct(Cart $cart, Product $product, CartRepository $cartRepository): void
    {
        $cartRepository->removeProduct($cart, $product);
    }

    /**
     * @Route("carts/{id}", methods={"GET"})
     */
    public function show(Cart $cart): Cart
    {
        return $cart;
    }
}