<?php


namespace App\Controller;


use App\Entity\Product;
use App\Repository\ProductRepository;
use App\Validator\ProductDataValidator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class ProductController
{
    /**
     * @Route("products/{id}", methods={"PATCH"})
     */
    public function update(Request $request, Product $product,
                           ProductRepository $productRepository, ProductDataValidator $productDataValidator): void
    {
        $data = json_decode($request->getContent(), true);
        $productDto = $productDataValidator->validateDataUpdate($data, $product);
        $productRepository->update($product, $productDto);
    }

    /**
     * @Route("products", methods={"POST"})
     */
    public function create(Request $request, ProductRepository $productRepository, ProductDataValidator $productDataValidator): void
    {
        $data = json_decode($request->getContent(), true);
        $productDto = $productDataValidator->validateDataCreate($data);
        $productRepository->add($productDto->toEntity());
    }
}