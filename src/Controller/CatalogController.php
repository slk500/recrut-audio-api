<?php


namespace App\Controller;


use App\Dto\ProductDto;
use App\Entity\Catalog;
use App\Entity\Product;
use App\Form\ProductDtoType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CatalogController extends AbstractController
{
    /**
     * @Route("catalogs/{id}/products", methods={"POST"})
     */
    public function create(Request $request, Catalog $catalog, EntityManagerInterface $entityManager)
    {
        $data = json_decode($request->getContent(), true);

        $form = $this->createForm(ProductDtoType::class, new ProductDto());
        $form->submit($data);

        $productDto = $form->getData();
        $product = $productDto->toEntity();

        $entityManager->persist($product);
        $catalog->add($product);

        $entityManager->flush();
    }

    /**
     * @Route("catalogs/{catalog}/products/{product}", methods={"DELETE"})
     */
    public function delete(Catalog $catalog, Product $product, EntityManagerInterface $entityManager)
    {
        $catalog->remove($product);
        $entityManager->flush();
    }
}