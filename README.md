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

$client = new Octopush\Client('*****@mail.com', '***API-KEY***');

$request = new Octopush\Request\SmsCampaign\SendSmsCampaignRequest();
$request->setRecipients([
    [
        'phone_number' => '+33600000000',
        'param1' => 'Alex',
    ]
]);
$request->setSender('AnySender');
$request->setText('Hello {param1}, HAPPY NEW YEAR');
$request->setType(Octopush\Constant\TypeEnum::SMS_PREMIUM);

// ---------------------------------
// optional
// ---------------------------------
$request->setPurpose(Octopush\Request\SmsCampaign\SendSmsCampaignRequest::ALERT_TRANSACTIONAL);
$request->setWithReplies(false);

$date = new DateTimeImmutable('2021-01-01 00:01:00');
$isoDateWithTimeZone = $date->format(DATE_ISO8601); // 2021-01-01T00:01:00+0100
$request->setSendAt($isoDateWithTimeZone); // also works with "2021-01-01 00:01:00", (Central European TimeZone by default)
// ---------------------------------

$content = $client->send($request);

// ---------------------------------
// Result example:
// ---------------------------------
```

```
{
    "sms_ticket": "sms_5fec89fe97109",
    "number_of_contacts": 1,
    "total_cost": 0.0333,
    "number_of_sms_needed": 1,
    "residual_credit": 99.5
}
```

#### Sending a Vocal SMS Campaign

```php
<?php

$client = new Octopush\Client('*****@mail.com', '***API-KEY***');

$request = new Octopush\Request\VocalCampaign\SendVocalCampaignRequest();
$request->setRecipients([
    [
        'phone_number' => '+33600000000',
    ]
]);
$request->setSender('AnySender');
$request->setText('Hello, HAPPY NEW YEAR');
$request->setType(Octopush\Constant\TypeEnum::VOCAL_SMS);
$request->setVoiceGender('female');
$request->setVoiceLanguage('fr-FR');

// ---------------------------------
// optional
// ---------------------------------
$request->setPurpose(Octopush\Request\VocalCampaign\SendVocalCampaignRequest::ALERT_TRANSACTIONAL);

$date = new DateTimeImmutable('2021-01-01 00:01:00');
$isoDateWithTimeZone = $date->format(DATE_ISO8601); // 2021-01-01T00:01:00+0100
$request->setSendAt($isoDateWithTimeZone); // also works with "2021-01-01 00:01:00", (Central European TimeZone by default)
// ---------------------------------

$content = $client->send($request);

// ---------------------------------
// Result example:
// ---------------------------------
```

```
{
    "vocal_ticket": "vocal_5fed928fda524",
    "number_of_contacts": 1,
    "total_cost": 0.03,
    "residual_credit": 99.5,
    "estimated_duration": 30
}
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

// ---------------------------------
// Result example:
// ---------------------------------
```

```
{
    "amount": 10,
    "unit": "vocal_sms",
    "wallet_packs": [
        {
            "id": "1d234c18-396c-12eb-b80e-02455c12550a",
            "credit": 10,
            "expiration_date": "2030-12-08T16:45:14+01:00"
        }
    ]
}
```

## cURL examples

You can find cURL examples in `curl-examples` directory.
