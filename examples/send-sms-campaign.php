<?php

require __DIR__.'/../vendor/autoload.php';

$client = new Octopush\Client('*****@mail.com', '***API-KEY***');

$request = new Octopush\Request\SmsCampaign\SendSmsCampaignRequest();
$request->setPurpose(Octopush\Request\SmsCampaign\SendSmsCampaignRequest::ALERT_TRANSACTIONAL);
$request->setRecipients([
    [
        'phone_number' => '+33600000000',
        'param1' => 'Alex',
    ]
]);
$request->setSender('AnySender');
$request->setText('Hello, {param1}');
$request->setType(Octopush\Constant\TypeEnum::SMS_PREMIUM);
$request->setWithReplies(false);
$request->setSendAt(new DateTimeImmutable('+1 hour'));

$content = $client->send($request);
/*
Array
(
    [sms_ticket] => sms_5f6c4e9fcd599
    [number_of_contacts] => 1
    [total_cost] => 0.062
)
 */
