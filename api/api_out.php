<?php

$url = "https://api.bind.com.mx/api/Activities";
$curl = curl_init($url);

curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

# Request headers
$headers = array(
    'Content-Type: application/json',
    'Cache-Control: no-cache',
    'Ocp-Apim-Subscription-Key: S4nz21522',);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

# Request body
$request_body = '{
    "Comment": "Prueba",
    "StartDate": "string",
    "EndDate": "string",
    "EventType": "00000000-0000-0000-0000-000000000000",
    "IsPublic": true,
    "Title": "string",
    "Repeatable": true,
    "RepeatInterval": 0,
    "RepeatType": 0,
    "Repetitions": 0,
    "ExternalID": "00000000-0000-0000-0000-000000000000",
    "ExternalIDType": 0
}';
curl_setopt($curl, CURLOPT_POSTFIELDS, $request_body);

$resp = curl_exec($curl);
curl_close($curl);
var_dump($resp);
?>