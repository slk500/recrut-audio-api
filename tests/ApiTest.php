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
     * @covers CatalogController::create
     */
    public function test_add_product_to_the_catalog()
    {
        $catalog = new Catalog();
        $this->entityManager->persist($catalog);
        $this->entityManager->flush();

        $this->client->request('PATCH', "/catalogs/{$catalog->getId()}",
            ['name' => $newProductName]
        );
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
        $this->client->request('PATCH', "/products/{$product->getId()}",
            ['name' => $newProductName]
        );

        $x = $this->client->getResponse()->getContent();

        $productFromDatabase = $this->entityManager
            ->getRepository(Product::class)
            ->findOneBy(['name' => $newProductName]);
        $this->assertSame($productFromDatabase->getName(), $newProductName);
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
        $cart->add($productOne);
        $cart->add($productTwo);

        $this->entityManager->persist($productOne);
        $this->entityManager->persist($productTwo);
        $this->entityManager->persist($cart);
        $this->entityManager->flush();

        $this->client->request('GET', "/carts/{$cart->getId()}");

        $jsonResponse = $this->client->getResponse()->getContent();
        $arrayResponse = json_decode($jsonResponse,true);
        $this->assertCount(2, $arrayResponse['data']['products']);
    }
}