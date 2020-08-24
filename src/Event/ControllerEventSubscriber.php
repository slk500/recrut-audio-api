<?php

namespace App\Event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class ControllerEventSubscriber implements EventSubscriberInterface
{
    private NormalizerInterface $serializer;

    public function __construct(NormalizerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public static function getSubscribedEvents()
    {
        return [
            'kernel.view' => [
                [
                    'sendResponse',
                ],
            ],
        ];
    }

    public function sendResponse(ViewEvent $event)
    {
        $value = $event->getControllerResult();

        $method = $event->getRequest()->getMethod();

        $statusCode = $this->getStatusCode($method);

        $normalized = $this->serializer->normalize($value);

        $response = new JsonResponse(['data' => $normalized], $statusCode);

        $event->setResponse($response);
    }

    public function getStatusCode(string $method): int
    {
        if ('POST' === $method) {
            return 201;
        }
        if ('DELETE' === $method) {
            return 204;
        }

        return 200;
    }
}
