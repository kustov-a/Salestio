<?php

namespace App\Responce;

use App\ApiClient\OpenExchangeRatesApiClient;
use App\Entity\CalculateCart;

class CalculateCartResponce
{
    private OpenExchangeRatesApiClient $exchangeRatesClient;

    public function __construct(OpenExchangeRatesApiClient $exchangeRatesClient)
    {
        $this->exchangeRatesClient = $exchangeRatesClient;
    }

    public function toArray(CalculateCart $calculateCart): array
    {
        $cartSum = 0;
        foreach ($calculateCart->getItems() as $item) {
            if ($item['currency'] === $calculateCart->getCheckoutCurrency()) {
                $cartSum += $item['price'] * $item['quantity'];
            } else {
                $convertedToCheckoutCurrency = $this->exchangeRatesClient->convertCurrency(
                    $item['currency'],
                    $calculateCart->getCheckoutCurrency(),
                    $item['price'] * $item['quantity']
                );

                $cartSum += $convertedToCheckoutCurrency;
            }
        }

        return [
            "checkoutPrice" => round($cartSum, 2),
            "checkoutCurrency" => $calculateCart->getCheckoutCurrency()
        ];
    }
}
