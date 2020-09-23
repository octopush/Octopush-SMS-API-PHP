# Octopush API

Octopush SMS API PHP client.

## Installation

The recommended way to install Octopush SMS API PHP client is through composer:

```bash
$ composer require octopush/sms-api
```

## Usage

#### Sending a text SMS Campaign

```php
<?php

$client = new Octopush\Client('*****@example.com', '***API_KEY***');

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
$request->setType(Octopush\Constant\ProductEnum::SMS_PREMIUM_PRODUCT);
$request->setWithReplies(false);
$request->setSendAt(new DateTimeImmutable('+1 hour'));
```

```
array:3 [
    "sms_ticket" => "sms_5f69d09739c2e"
    "number_of_contacts" => "1"
    "total_cost" => "0.097"
]
```

#### Sending a Vocal SMS Campaign

```php
<?php

$client = new Octopush\Client('*****@example.com', '***API_KEY***');

$request = new Octopush\Request\VocalCampaign\SendVocalCampaignRequest();
$request->setPurpose(Octopush\Request\SmsCampaign\SendSmsCampaignRequest::ALERT_TRANSACTIONAL);
$request->setRecipients([
    [
        'phone_number' => '+336********',
    ]
]);
$request->setSender('AnySender');
$request->setText('Hello!');
$request->setType(Octopush\Constant\ProductEnum::VOCAL_SMS_PRODUCT);
$request->setVoiceGender('female');
$request->setVoiceLanguage('fr-FR');
$request->setSendAt(new DateTimeImmutable('+1 hour'));
```

```
array:3 [
    "vocal_ticket" => "vocal_1f77a09129c2e"
    "number_of_contacts" => "1"
    "total_cost" => "0.097"
]
```

#### Checking your credit

```php
<?php

$client = new Octopush\Client('*****@example.com', '***API_KEY***');

$request = new Octopush\Request\GetCreditRequest();
$request->setProductName(Octopush\Constant\ProductEnum::VOCAL_SMS_PRODUCT);
$request->setCountryCode('FR');
$request->setWithDetails(false);
```

```
array:3 [
    "amount" => "216.027"
    "unit" => "vocal_sms"
    "wallet_packs" => "NULL"
]
```
