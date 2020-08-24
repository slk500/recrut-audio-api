<?php /** @noinspection PhpIllegalPsrClassPathInspection */

declare(strict_types=1);

namespace App\Test;

use App\Entity\Cart;
use App\Entity\Catalog;
use App\Entity\Product;
use PHPUnit\Framework\TestCase;

class UnitTest extends TestCase
{
    public function test_add_product_to_the_catalog()
    {
        $catalog = new Catalog();
        $product = new Product(
            'product 1',
            100
        );

        $catalog->add($product);

        $this->assertFalse($catalog->isEmpty());
    }

    public function test_remove_product_from_the_catalog()
    {
        $catalog = new Catalog();
        $product = new Product(
            'product 1',
            100
        );

        $catalog->add($product);
        $this->assertFalse($catalog->isEmpty());

        $catalog->remove($product);
        $this->assertTrue($catalog->isEmpty());
    }

    public function test_update_product_name()
    {
        $product = new Product(
            'product 1',
            100
        );

        $newProductName = 'new product name';
        $product->setName($newProductName);

        $this->assertSame($product->getName(), $newProductName);
    }

    public function test_update_product_price()
    {
        $product = new Product(
            'product 1',
            100
        );

        $newProductPrice = 200;
        $product->setPrice($newProductPrice);

        $this->assertSame($product->getPrice(), $newProductPrice);
    }

    public function test_list_all_products_in_the_catalog_as_a_paginated_list_with_at_most_3_products_per_page()
    {
        $this->markTestSkipped('API');
    }

    public function test_create_a_cart()
    {
        $this->assertInstanceOf(Cart::class, new Cart());
    }

    public function test_add_product_to_the_cart()
    {
        $cart = new Cart();
        $product = new Product(
            'product 1',
            100
        );

        $cart->add($product);

        $this->assertNotEmpty($cart->getProducts());
    }

    public function test_remove_product_from_the_cart()
    {
        $cart = new Cart();
        $product = new Product(
            'product 1',
            100
        );

        $cart->add($product);
        $this->assertNotEmpty($cart->getProducts());

        $cart->remove($product);
        $this->assertEmpty($cart->getProducts());
    }

    public function test_list_all_products_in_the_cart()
    {
        $cart = new Cart();
        $productOne = new Product(
            'product 1',
            100
        );
        $productTwo = new Product(
            'product 2',
            200
        );

        $cart->add($productOne);
        $cart->add($productTwo);

        $this->assertCount(2, $cart->getProducts());
        $this->assertContainsOnlyInstancesOf(Product::class, $cart->getProducts());

    }

    public function test_cart_can_contain_a_max_of_3_products()
    {
        $cart = new Cart();
        $productOne = new Product('product 1',100);
        $productTwo = new Product('product 2', 200);
        $productThree = new Product('product 3', 300);
        $productFour = new Product('product 2', 200);

        $cart->add($productOne);
        $cart->add($productTwo);
        $cart->add($productThree);

        $this->expectExceptionMessage('cart can contain a max. of 3 products');
        $cart->add($productFour);
    }

    public function test_cart_should_display_a_total_price_of_all_products_in_it()
    {
        $cart = new Cart();
        $productOne = new Product(
            'product 1',
            100
        );
        $productTwo = new Product(
            'product 2',
            200
        );

        $cart->add($productOne);
        $cart->add($productTwo);

        $this->assertEquals($cart->getProductsPrice(), 300);
    }
}
