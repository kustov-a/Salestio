<?php

namespace App\Entity;

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

    public function __construct(array $items, string $checkoutCurrency)
    {
        $this->items = $items;
        $this->checkoutCurrency = $checkoutCurrency;
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
}
