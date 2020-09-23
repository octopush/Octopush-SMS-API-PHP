<?php

$payload = [
    'recipients' => [['phone_number' => '+33600000000']],
    'text' => 'Test vocal Campaign.',
    'type' => 'vocal_sms',
    'purpose' => 'alert',
    'sender' => 'SMS',
    'send_at' => '2020-10-03T07:42:39-07:00',
    'voice_gender' => 'female',
    'voice_language' => 'fr-FR',
];

/*
 {
    "recipients":[{"phone_number":"+33600000000"}],
    "text":"Test vocal Campaign.",
    "type":"vocal_sms",
    "purpose":"alert",
    "sender":"SMS",
    "send_at":"2020-10-03T07:42:39-07:00",
    "voice_gender":"female",
    "voice_language":"fr-FR"
}
 */
$jsonEncodedPayload = json_encode($payload);

$curl = curl_init();

curl_setopt_array(
    $curl,
    [
        CURLOPT_URL => 'https://backend.octopush.com/v1/public/vocal-campaign/send',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => $jsonEncodedPayload,
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/json',
            'api-key: ***API-KEY***',
            'api-login:  *****@mail.com',
            'cache-control: no-cache',
        ],
    ]
);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
    echo 'cURL Error #:'.$err;
} else {
    echo $response;
    // {"vocal_ticket":"vocal_5f6c49f92a476","number_of_contacts":1,"total_cost":0.1}
}
