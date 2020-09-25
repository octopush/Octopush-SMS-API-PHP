# Octopush API

Octopush SMS API PHP client.

## Installation

```bash
$ composer require octopush/sms-api
```

## Usage

#### Sending a text SMS Campaign

```php
<?php

$client = new Octopush\Client('*****@example.com', '***API-KEY***');

$request = new Octopush\Request\SmsCampaign\SendSmsCampaignRequest();
$request->setPurpose(Octopush\Request\SmsCampaign\SendSmsCampaignRequest::ALERT_TRANSACTIONAL);
$request->setRecipients([
    [
        'phone_number' => '+336********',
        'param1' => 'Alex',
    ]
]);
$request->setSender('AnySender');
$request->setText('Hello, {param1}');
$request->setType(Octopush\Constant\TypeEnum::SMS_PREMIUM);
$request->setWithReplies(false);
$request->setSendAt(new DateTimeImmutable('+1 hour'));

$content = $client->send($request);
```

```
Array
(
    [sms_ticket] => sms_5f6c4e9fcd599
    [number_of_contacts] => 1
    [total_cost] => 0.062
)
```

#### Sending a Vocal SMS Campaign

```php
<?php

$client = new Octopush\Client('*****@example.com', '***API-KEY***');

$request = new Octopush\Request\VocalCampaign\SendVocalCampaignRequest();
$request->setPurpose(Octopush\Request\SmsCampaign\SendSmsCampaignRequest::ALERT_TRANSACTIONAL);
$request->setRecipients([
    [
        'phone_number' => '+336********',
    ]
]);
$request->setSender('AnySender');
$request->setText('Hello!');
$request->setType(Octopush\Constant\TypeEnum::VOCAL_SMS);
$request->setVoiceGender('female');
$request->setVoiceLanguage('fr-FR');
$request->setSendAt(new DateTimeImmutable('+1 hour'));

$content = $client->send($request);
```

```
Array
(
    [vocal_ticket] => vocal_5f6c4e4a2afc9
    [number_of_contacts] => 1
    [total_cost] => 0.1
)
```

#### Checking your credit

```php
<?php

$client = new Octopush\Client('*****@example.com', '***API-KEY***');

$request = new Octopush\Request\GetCreditRequest();
$request->setProductName(Octopush\Constant\TypeEnum::VOCAL_SMS);
$request->setCountryCode('FR');
$request->setWithDetails(true);

$content = $client->send($request);
```

```
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
```

## cURL examples

You can find cURL examples in `curl-examples` directory.
