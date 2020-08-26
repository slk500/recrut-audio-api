<?php

declare(strict_types=1);

namespace App\EventListener;

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

    public static function getSubscribedEvents(): array
    {
        return [
            ViewEvent::class => 'sendResponse'
        ];
    }

    public function sendResponse(ViewEvent $event): void
    {
        $method = $event->getRequest()->getMethod();
        $statusCode = $this->getStatusCode($method);

        $data = $event->getControllerResult();
        $normalized = $this->serializer->normalize($data);

        $response = new JsonResponse(['data' => $normalized], $statusCode);

        $event->setResponse($response);
    }

    public function getStatusCode(string $method): int
    {
        if ('POST' === $method) {
            return 201;
        }
        if ('DELETE' === $method || 'PATCH' === $method) {
            return 204;
        }

        return 200;
    }
}
