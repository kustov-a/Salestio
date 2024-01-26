<?php

namespace App\Entity;

use App\ApiClient\OpenExchangeRatesApiClient;
use Exception;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\Required;
use Symfony\Component\Validator\Constraints\All;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints\GreaterThan;

class CalculateCart
{
    #[All(
        new Collection(
            fields: [
                'currency' => new Required([
                    new NotBlank,
                    new Type(type: "string")
                ]),
                'price' => new Required([
                    new NotBlank,
                    new Type(type: "numeric"),
                    new GreaterThan(value: 0)
                ]),
                'quantity' => new Required([
                    new NotBlank,
                    new Type(type: "int"),
                    new GreaterThan(value: 0)
                ])
            ]
        )
    )]
    private array $items;
    #[NotBlank]
    private string $checkoutCurrency;
    private OpenExchangeRatesApiClient $exchangeRatesClient;

    public function __construct(array $items, string $checkoutCurrency)
    {
        $this->items = $items;
        $this->checkoutCurrency = $checkoutCurrency;
        $this->exchangeRatesClient = new OpenExchangeRatesApiClient;
    }

    /**
     * @return array
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @return string
     */
    public function getCheckoutCurrency(): string
    {
        return $this->checkoutCurrency;
    }

    /**
     * @return float
     * @throws Exception
     */
    public function calculateCart(): float
    {
        $cartSum = 0;
        foreach ($this->getItems() as $item) {
            if ($item['currency'] === $this->getCheckoutCurrency()) {
                $cartSum += $item['price'] * $item['quantity'];
            } else {
                $convertedToCheckoutCurrency = $this->exchangeRatesClient->convertCurrency(
                    $item['currency'],
                    $this->getCheckoutCurrency(),
                    $item['price'] * $item['quantity']
                );

                $cartSum += $convertedToCheckoutCurrency;
            }
        }

        return round($cartSum, 2);
    }
}
