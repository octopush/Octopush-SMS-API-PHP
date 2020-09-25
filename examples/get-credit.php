<?php

require __DIR__.'/../vendor/autoload.php';

$client = new Octopush\Client('*****@mail.com', '***API-KEY***');

$request = new Octopush\Request\GetCreditRequest();
$request->setProductName(Octopush\Constant\TypeEnum::VOCAL_SMS);
$request->setCountryCode('FR');
$request->setWithDetails(true);

$content = $client->send($request);
/*
Array
(
    [amount] => 1074
    [unit] => vocal_sms
    [wallet_packs] => Array
        (
            [0] => Array
                (
                    [id] => 12dda478-fc11-51eb-813c-024417120004
                    [credit] => 10.144
                    [expiration_date] => 2030-09-21T15:55:14+02:00
                )
        )
)
 */
