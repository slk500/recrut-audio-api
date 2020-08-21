<?php

declare(strict_types=1);

namespace App\ValueObject;


class Money
{
    private int $quantity;

    private string $currency;

    public function __construct(int $quantity, string $currency = 'PLN')
    {
        $this->quantity = $quantity;
        $this->currency = $currency;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }
}