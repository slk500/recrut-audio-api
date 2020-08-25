<?php


namespace App\Controller;


use App\Entity\Catalog;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
     * @Route("catalogs/{catalog}/products", methods={"GET"})
     */
    public function listProducts(Request $request, Catalog $catalog, PaginatorInterface $paginator)
    {
        $maxPerPage = 3;
        $pagination = $paginator->paginate(
            $catalog->getProducts(),
            $request->query->getInt('page', 1),
            $maxPerPage
        );

        return [
            'products' => $pagination,
            'pagination' =>
                [
                    'count' =>
                        [
                            'all' => $pagination->getTotalItemCount(),
                            'current' => $pagination->getCurrentPageNumber(),
                            'maxPerPage' => $pagination->getItemNumberPerPage()
                        ]
                ]
        ];
    }
}