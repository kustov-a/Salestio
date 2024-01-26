<?php

namespace App\Tests\Functional\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

class CartApiControllerTest extends WebTestCase
{
    public function testRequestRespondedIsSuccessful(): void
    {
        $client = static::createClient([], [
            'HTTP_HOST' => 'localhost:888/api'
        ]);
        $requestData = [
            "items" => [
                [
                    "currency" => "EUR",
                    "price" => 49.99,
                    "quantity" => 1
                ]
            ],
            "checkoutCurrency" => "EUR"
        ];
        $client->request(
            Request::METHOD_POST,
            '/cart/calculate-cart/',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($requestData)
        );

        $this->assertResponseIsSuccessful();
        $responseResult = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals(49.99, $responseResult['checkoutPrice']);
        $this->assertEquals("EUR", $responseResult['checkoutCurrency']);
    }
}
