<?php

// PUT request to udpate an existing record.

$apiUrl = 'http://api-<your domain>.coresense.com/v1/category/1';
$userId = '<your user id>';
$apiKey = '<your api key>';

require_once 'functions.php';

$data = json_encode([
	'category' => 'foo',
	'label' => 'bar',
	'active' => true,
]);

$curl = curl_init($apiUrl);
curl_setopt_array($curl, [
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_HTTPHEADER => [
        'Accept: application/json',
        'Content-Type: application/json',
        'Content-Length: ' . strlen($data),
		'X-Auth-Token: ' . token($userId, $apiKey),
	],
	CURLOPT_CUSTOMREQUEST => 'PUT',
    CURLOPT_POSTFIELDS => $data,
]);
$result = curl_exec($curl);
$info = curl_getinfo($curl);
curl_close($curl);

if ($result === false) {
	echo "request failed\n";
	print_r($info);
	exit;
}

if ($info['http_code'] < 200 || $info['http_code'] > 299) {
	echo "request succeeded but response contained an error\n";
	print_r(json_decode($result, true));
	exit;
}

echo "request succeeded\n";
