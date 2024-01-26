<?php

namespace App\Responce;

use App\ApiClient\OpenExchangeRatesApiClient;
use App\Entity\CalculateCart;

class CalculateCartResponse
{
    public function toArray(float $cartSum, string $cartCurrency): array
    {
        return [
            "checkoutPrice" => $cartSum,
            "checkoutCurrency" => $cartCurrency
        ];
    }
}
