<?php

declare(strict_types=1);

namespace App\Serializer\Normalizer;

use App\Entity\Cart;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerAwareInterface;
use Symfony\Component\Serializer\SerializerAwareTrait;

class CartNormalizer implements NormalizerInterface, SerializerAwareInterface
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
         * @var $object Cart
         */
        return [
            'href' => $this->router->generate('app_cart_show', ['id' => $object->getId()]),
            'id'   => $object->getId(),
            'products' => $this->serializer->normalize($object->getProducts(), $format, $context),
            'totalPrice' => $object->getProductsPrice()
        ];
    }

    public function supportsNormalization($data, string $format = null): bool
    {
        return $data instanceof Cart;
    }
}
