<?php

namespace App\Controller\Api;

use App\Entity\CalculateCart;
use App\Responce\CalculateCartResponce;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api/cart', name: 'api')]
class CartApiController extends AbstractController
{
    private CalculateCartResponce $calculateCartResponce;

    public function __construct(CalculateCartResponce $calculateCartResponce)
    {
        $this->calculateCartResponce = $calculateCartResponce;
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

        return $this->json($this->calculateCartResponce->toArray($calculateCart));
    }
}