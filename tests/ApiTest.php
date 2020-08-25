<?php


namespace App\Tests;


use App\Entity\Cart;
use App\Entity\Catalog;
use App\Entity\Product;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApiTest extends WebTestCase
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var KernelBrowser
     */
    private $client;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->entityManager = $this->client->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    /**
     * @covers CatalogController::addProduct
     */
    public function test_add_product_to_the_catalog()
    {
        $catalog = new Catalog();
        $this->entityManager->persist($catalog);
        $product = new Product(
            'product 1',
            100
        );
        $this->entityManager->persist($product);
        $this->entityManager->flush();

        $this->client->request('PATCH', "/catalogs/{$catalog->getId()}/products/{$product->getId()}");

        $this->assertSame(204, $this->client->getResponse()->getStatusCode());
        $this->entityManager->refresh($catalog);
        $this->assertNotEmpty($catalog->getProducts());
    }

    /**
     * @covers CatalogController::removeProduct
     */
    public function test_remove_product_from_the_catalog()
    {
        $catalog = new Catalog();
        $product = new Product(
            'product 1',
            100
        );
        $this->entityManager->persist($product);
        $this->entityManager->persist($catalog);
        $catalog->addProduct($product);
        $this->entityManager->flush();

        $this->client->request('DELETE', "/catalogs/{$catalog->getId()}/products/{$product->getId()}");

        $this->assertSame(204, $this->client->getResponse()->getStatusCode());
        $this->entityManager->refresh($catalog);
        $this->assertEmpty($catalog->getProducts());
    }


    /**
     * @covers ProductController::update
     */
    public function test_update_product_name()
    {
        $product = new Product(
            'product 1',
            100
        );
        $this->entityManager->persist($product);
        $this->entityManager->flush();

        $newProductName = 'new product name';
        $this->client->request('PATCH', "/products/{$product->getId()}", [], [], [],
            json_encode([
            'name'=> $newProductName
        ]));

        $this->assertSame(204, $this->client->getResponse()->getStatusCode());

        $this->entityManager->refresh($product);
        $this->assertSame($product->getName(), $newProductName);
    }

    /**
     * @covers ProductController::update
     */
    public function test_update_product_price()
    {
        $product = new Product(
            'product 1',
            100
        );
        $this->entityManager->persist($product);
        $this->entityManager->flush();

        $newProductPrice = 200;
        $this->client->request('PATCH', "/products/{$product->getId()}", [], [], [],
            json_encode([
            'price' => $newProductPrice
        ]));


        $this->assertSame(204, $this->client->getResponse()->getStatusCode());
        $this->entityManager->refresh($product);
        $this->assertSame($product->getPrice(), $newProductPrice);
    }

    /**
     * @covers CatalogController::listProducts
     */
    public function test_list_all_products_in_the_catalog_as_a_paginated_list_with_at_most_3_products_per_page()
    {
        $productOne = new Product(
            'product 1',
            100
        );
        $productTwo = new Product(
            'product 2',
            200
        );
        $productThree = new Product(
            'product 3',
            300
        );
        $productFour = new Product(
            'product 4',
            400
        );
        $productFive = new Product(
            'product 5',
            500
        );
        $productSix = new Product(
            'product 6',
            600
        );

        $catalog = new Catalog();
        $catalog->addProduct($productOne);
        $catalog->addProduct($productTwo);
        $catalog->addProduct($productThree);
        $catalog->addProduct($productFour);
        $catalog->addProduct($productFive);
        $catalog->addProduct($productSix);

        $this->entityManager->persist($productOne);
        $this->entityManager->persist($productTwo);
        $this->entityManager->persist($productThree);
        $this->entityManager->persist($productFour);
        $this->entityManager->persist($productFive);
        $this->entityManager->persist($productSix);
        $this->entityManager->persist($catalog);
        $this->entityManager->flush();

        $this->client->request('GET', "/catalogs/{$catalog->getId()}/products");

        $jsonResponse = $this->client->getResponse()->getContent();
        $arrayResponse = json_decode($jsonResponse,true);
        $this->assertCount(3, $arrayResponse['data']['products']);
        $this->assertCount(3, $arrayResponse['data']['products']);
    }

    /**
     * @covers ProductController::update
     */
    public function test_create_a_cart()
    {
        $this->client->request('POST', "/carts");

        $this->assertSame(201, $this->client->getResponse()->getStatusCode());

        $carts = $this->entityManager->getRepository(Cart::class)->findAll();
        $this->assertNotEmpty($carts);
    }

    /**
     * @covers CartController::addProduct
     */
    public function test_add_product_to_the_cart()
    {
        $cart = new Cart();
        $product = new Product(
            'product 1',
            100
        );

        $this->entityManager->persist($cart);
        $this->entityManager->persist($product);
        $this->entityManager->flush();

        $this->client->request('PATCH', "/carts/{$cart->getId()}/products/{$product->getId()}");

        $this->assertSame(204, $this->client->getResponse()->getStatusCode());

        $this->entityManager->refresh($cart);
        $this->assertNotEmpty($cart->getProducts());
    }

    public function test_remove_product_from_the_cart()
    {
        $cart = new Cart();
        $product = new Product(
            'product 1',
            100
        );

        $this->entityManager->persist($cart);
        $this->entityManager->persist($product);
        $this->entityManager->flush();

        $this->client->request('DELETE', "/carts/{$cart->getId()}/products/{$product->getId()}");

        $this->assertSame(204, $this->client->getResponse()->getStatusCode());

        $this->entityManager->refresh($cart);
        $this->assertEmpty($cart->getProducts());
    }

    public function test_list_all_products_in_the_cart()
    {
        $productOne = new Product(
            'product 1',
            100
        );
        $productTwo = new Product(
            'product 2',
            200
        );

        $cart = new Cart();
        $cart->addProduct($productOne);
        $cart->addProduct($productTwo);

        $this->entityManager->persist($productOne);
        $this->entityManager->persist($productTwo);
        $this->entityManager->persist($cart);
        $this->entityManager->flush();

        $this->client->request('GET', "/carts/{$cart->getId()}");

        $jsonResponse = $this->client->getResponse()->getContent();
        $arrayResponse = json_decode($jsonResponse,true);
        $this->assertCount(2, $arrayResponse['data']['products']);
    }

    public function test_cart_should_display_a_total_price_of_all_products_in_it()
    {
        $productOne = new Product(
            'product 1',
            100
        );
        $productTwo = new Product(
            'product 2',
            200
        );

        $cart = new Cart();
        $cart->addProduct($productOne);
        $cart->addProduct($productTwo);

        $this->entityManager->persist($productOne);
        $this->entityManager->persist($productTwo);
        $this->entityManager->persist($cart);
        $this->entityManager->flush();

        $this->client->request('GET', "/carts/{$cart->getId()}");

        $jsonResponse = $this->client->getResponse()->getContent();
        $arrayResponse = json_decode($jsonResponse,true);
        $this->assertCount(2, $arrayResponse['data']['products']);
        $this->assertEquals(300, $arrayResponse['data']['totalPrice']);
    }
}