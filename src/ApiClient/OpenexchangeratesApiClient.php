<?php

namespace App\ApiClient;

use Symfony\Component\Dotenv\Dotenv;

class OpenexchangeratesApiClient
{
    private string $exchangeRatesApiKey;

    public function __construct()
    {
        (new Dotenv())->load(__DIR__ . '/.env');
        $this->exchangeRatesApiKey = $_ENV['OPENEXCHANGERATES_API_KEY'];
    }
}
