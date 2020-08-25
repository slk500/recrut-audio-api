<?php

declare(strict_types=1);

namespace App\Validator;


use App\Dto\ProductDto;
use App\Entity\Product;
use App\Form\ProductDtoType;
use Symfony\Component\Form\FormFactoryInterface;

final class ProductDataValidator
{
    private FormFactoryInterface $formFactory;

    public function __construct(FormFactoryInterface $formFactory)
    {
        $this->formFactory = $formFactory;
    }

    public function validateDataCreate(array $data): ProductDto
    {
        $form = $this->formFactory->create(ProductDtoType::class, new ProductDto());
        $form->submit($data);

        return $form->getData();
    }

    public function validateDataUpdate(array $data, Product $product): ProductDto
    {
        $form = $this->formFactory->create(ProductDtoType::class, ProductDto::fromEntity($product));
        $form->submit($data, false);

        return $form->getData();
    }
}