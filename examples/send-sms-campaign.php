<?php

require __DIR__.'/../vendor/autoload.php';

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
/*
{
    "sms_ticket": "sms_5fec89fe97109",
    "number_of_contacts": 1,
    "total_cost": 0.0333,
    "number_of_sms_needed": 1,
    "residual_credit": 99.5
}
 */
// ---------------------------------
