<?php


namespace App\Controller;


use App\Entity\Catalog;
use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CatalogController
{
    /**
     * @Route("catalogs/{id}/products", methods={"POST"})
     */
    public function create(Request $request, Catalog $catalog, ProductRepository $productRepository)
    {
        $name = $request->request->get('name');
        $product = $productRepository->findOneByName($name);

        $catalog->add($product);
    }

    /**
     * @Route("catalogs/{catalog_id}/products/{product_id}", methods={"DELETE"})
     */
    public function delete(Catalog $catalog, Product $product)
    {
        $catalog->remove($product);
    }
}