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
        CURLOPT_POSTFIELDS => "{\n  \"recipients\": [\n  \t   {\n  \t   \t\t\"phone_number\": \"+336******\",\n  \t   \t\t\"param1\": \"\"\n  \t   }\n  ],\n  \"text\": \"Test with stop mention. STOP au XXXXX\",\n  \"type\": \"sms_premium\",\n  \"purpose\": \"wholesale\",\n  \"sender\": \"SomeSender\",\n  \"send_at\": \"2020-07-29T11:00:39-07:00\",\n  \"with_answers\": false\n}",
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
