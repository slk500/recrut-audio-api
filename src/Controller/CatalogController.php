<?php

declare(strict_types=1);

namespace App\Controller;


use App\Entity\Catalog;
use App\Entity\Product;
use App\Pagination\ProductCollection;
use App\Repository\CatalogRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class CatalogController
{
    /**
     * @Route("catalogs/{catalog}/products/{product}", methods={"PATCH"})
     */
    public function addProduct(Catalog $catalog, Product $product, CatalogRepository $catalogRepository): void
    {
       $catalogRepository->addProduct($catalog, $product);
    }

    /**
     * @Route("catalogs/{catalog}/products/{product}", methods={"DELETE"})
     */
    public function removeProduct(Catalog $catalog, Product $product, CatalogRepository $catalogRepository): void
    {
        $catalogRepository->removeProduct($catalog, $product);
    }

    /**
     * @Route("catalogs/{catalog}/products", methods={"GET"})
     */
    public function listProducts(Request $request, Catalog $catalog, ProductCollection $productCollection)
    {
        return $productCollection->toArray(
            $catalog->getProducts(),
            $request->query->getInt('page', 1)
        );
    }
}