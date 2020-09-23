<?php

require __DIR__.'/../vendor/autoload.php';

$client = new Octopush\Client('*****@mail.com', '***API-KEY***');

$request = new Octopush\Request\VocalCampaign\SendVocalCampaignRequest();
$request->setPurpose(Octopush\Request\SmsCampaign\SendSmsCampaignRequest::ALERT_TRANSACTIONAL);
$request->setRecipients([
    [
        'phone_number' => '+33600000000',
    ]
]);
$request->setSender('AnySender');
$request->setText('Hello!');
$request->setType(Octopush\Constant\TypeEnum::VOCAL_SMS);
$request->setVoiceGender('female');
$request->setVoiceLanguage('fr-FR');
$request->setSendAt(new DateTimeImmutable('+1 hour'));

$content = $client->send($request);
/*
Array
(
    [vocal_ticket] => vocal_5f6c4e4a2afc9
    [number_of_contacts] => 1
    [total_cost] => 0.1
)
 */
