<?php


namespace App\Controller;


use App\Dto\ProductDto;
use App\Entity\Product;
use App\Form\ProductDtoType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("products/{id}", methods={"PATCH"})
     */
    public function update(Request $request, Product $product, EntityManagerInterface $entityManager)
    {
        $data = json_decode($request->getContent(), true);

        $form = $this->createForm(ProductDtoType::class, ProductDto::fromEntity($product));
        $form->submit($data, false);

        $productDto = $form->getData();
        $product->setName($productDto->name);
        $product->setPrice($productDto->price);

        $entityManager->flush();
    }
}