<?php

require __DIR__.'/../vendor/autoload.php';

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
/*
{
    "vocal_ticket": "vocal_5fed928fda524",
    "number_of_contacts": 1,
    "total_cost": 0.03,
    "residual_credit": 99.5,
    "estimated_duration": 30
}
 */
// ---------------------------------
