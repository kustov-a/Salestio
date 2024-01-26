## Install instruction

1. Docker and docker-compose must be installed on your computer
1. Clone project from:
> https://github.com/kustov-a/Salestio
3. Go to the directory with the project
4. Run commands:
> cp .env.dist .env
>
> cp phpunit.xml.dist phpunit.xml
5. Run commands in terminal:
> make build
>
> make up
>
> make bash
> composer install
6. In Postman, or other app:
> POST http://localhost:888/api/cart/calculate-cart/
> 
> *Body-params:*
> 
>> {
"items": {
"42": {
"currency": "EUR",
"price": 49.99,
"quantity": 1
},
"55": {
"currency": "USD",
"price": 12,
"quantity": 3
}
},
"checkoutCurrency": "EUR"
}