<?php

namespace App\ApiClient;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class OpenExchangeRatesApiClient
{
    private string $exchangeRatesApiKey;
    private HttpClientInterface $client;

    const BASE_SERVICE_URL = 'https://openexchangerates.org/api';

    const CONVERT_CURRENCY_ENDPOINT = "/convert";

    public function __construct()
    {
        $this->client = HttpClient::create();
        $this->exchangeRatesApiKey = $_ENV['OPENEXCHANGERATES_API_KEY'];
    }

    /**
     * @param string $currencyFrom
     * @param string $currencyTo
     * @param float $amount
     * @return float
     * @throws \Exception
     */
    public function convertCurrency(string $currencyFrom, string $currencyTo, float $amount): float
    {
        $url = sprintf(
            '%s%s/%s/%s/%s?app_id=%s&prettyprint=false',
            self::BASE_SERVICE_URL,
            self::CONVERT_CURRENCY_ENDPOINT,
            $amount,
            $currencyFrom,
            $currencyTo,
            $this->exchangeRatesApiKey
        );

        $response = $this->client->request('GET', $url, [
            'headers' => [
                'Accept' => 'application/json',
            ],
        ]);
        $statusCode = $response->getStatusCode();
        $content = $response->getContent();

        if ($statusCode === 200) {
            if (isset($content['response'])) {
                $convertedAmount = $content['response']['amount'];
                return $convertedAmount;
            } else {
                throw new \Exception('Invalid response format');
            }
        } else {
            throw new \Exception('Error occurred: ' . $statusCode);
        }
    }
}
