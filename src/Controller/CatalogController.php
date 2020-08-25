<?php


namespace App\Controller;


use App\Entity\Catalog;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CatalogController extends AbstractController
{
    /**
     * @Route("catalogs/{catalog}/products/{product}", methods={"PATCH"})
     */
    public function addProduct(Catalog $catalog, Product $product, EntityManagerInterface $entityManager): void
    {
        $catalog->addProduct($product);
        $entityManager->flush();
    }

    /**
     * @Route("catalogs/{catalog}/products/{product}", methods={"DELETE"})
     */
    public function delete(Catalog $catalog, Product $product, EntityManagerInterface $entityManager): void
    {
        $catalog->removeProduct($product);
        $entityManager->flush();
    }

    /**
     * @Route("catalogs/{catalog}", methods={"GET"})
     */
    public function show(Catalog $catalog): Catalog
    {
        return $catalog;
    }
}