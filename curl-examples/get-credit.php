<?php

$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_PORT => "3001",
    CURLOPT_URL => "https://backend.octopush.com/v1/public/wallet/check-balance?country_code=LU&product_name=sms_low_cost&with_details=1",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_POSTFIELDS => "",
    CURLOPT_HTTPHEADER => array(
        "Content-Type: application/json",
        "api-key: ***API-KEY***",
        "api-login: *****@*****.***",
        "cache-control: no-cache"
    ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
    echo "cURL Error #:".$err;
} else {
    echo $response;
}
