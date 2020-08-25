<?php

declare(strict_types=1);

namespace App\Serializer\Normalizer;

use App\Entity\Cart;
use App\Entity\Product;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerAwareInterface;
use Symfony\Component\Serializer\SerializerAwareTrait;

class ProductNormalizer implements NormalizerInterface, SerializerAwareInterface
{
    use SerializerAwareTrait;

    private RouterInterface $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function normalize($object, string $format = null, array $context = [])
    {
        /**
         * @var $object Product
         */
        return [
            'id'   => $object->getId(),
            'name' => $object->getName(),
            'price' => $object->getPrice()
        ];
    }

    public function supportsNormalization($data, string $format = null): bool
    {
        return $data instanceof Product;
    }
}
