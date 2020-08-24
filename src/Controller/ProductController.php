<?php


namespace App\Controller;


use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProductController
{
    /**
     * @Route("products/{id}", methods={"PATCH"})
     */
    public function update(Request $request, Product $product, EntityManagerInterface $entityManager)
    {
        $name = $request->request->get('name');
        $product->setName($name);
        $entityManager->flush();
    }
}