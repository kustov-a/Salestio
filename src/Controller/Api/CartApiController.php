<?php

namespace App\Controller\Api;

use App\ApiClient\OpenexchangeratesApiClient;
use App\Entity\CalculateCart;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api/cart', name: 'api')]
class CartApiController extends AbstractController
{
    private OpenexchangeratesApiClient $exchangeRatesClient;

    public function __construct(OpenexchangeratesApiClient $exchangeRatesClient)
    {
        $this->exchangeRatesClient = $exchangeRatesClient;
    }

    #[Route('/calculate-cart', name: 'calculateCart')]
    public function calculateCart(Request $request, ValidatorInterface $validator): JsonResponse
    {
        $requestData = json_decode($request->getContent(), true);
        $calculateCart = new CalculateCart($requestData['items'], $requestData['checkoutCurrency']);
        $errors = $validator->validate($calculateCart);

        if (count($errors) > 0) {
            return $this->json($errors, 400);
        }

        $exchangeRates = $this->exchangeRatesClient->getExchangeRates();

        return $this->json([$requestData, $calculateCart]);
    }
}