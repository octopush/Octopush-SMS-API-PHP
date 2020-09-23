<?php

$curl = curl_init();

curl_setopt_array(
    $curl,
    array(
        CURLOPT_URL => "https://backend.octopush.com/v1/public/vocal-campaign/send",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "{\n  \"recipients\": [\n  \t   {\n  \t   \t\t\"phone_number\": \"+336*******\"\n  \t   }\n  ],\n  \"text\": \"Test vocal Campaign.\",\n  \"type\": \"vocal_sms\",\n  \"purpose\": \"alert\",\n  \"sender\": \"+12345\",\n  \"send_at\": \"2018-10-03T07:42:39-07:00\",\n  \"voice_gender\": \"female\",\n  \"voice_language\": \"fr-FR\"\n}",
        CURLOPT_HTTPHEADER => array(
            "Content-Type: application/json",
            "api-key: ***API-KEY***",
            "api-login: *****@*****.***",
            "cache-control: no-cache"
        ),
    )
);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
    echo "cURL Error #:".$err;
} else {
    echo $response;
}
