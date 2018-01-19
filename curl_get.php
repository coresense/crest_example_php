<?php

// GET request to read records.

$apiUrl = 'http://api-<your domain>.coresense.com/v1/category?fields=id,category,label';
$userId = '<your user id>';
$apiKey = '<your api key>';

require_once 'functions.php';

$curl = curl_init($apiUrl);
curl_setopt_array($curl, [
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_HTTPHEADER => [
        'Accept: application/json',
		'X-Auth-Token: ' . token($userId, $apiKey),
	],
	CURLOPT_CUSTOMREQUEST => 'GET',
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
	echo "request completed but response contained an error\n";
	print_r(json_decode($result, true));
	exit;
}

foreach (json_decode($result, true) as $row) {
	print_r($row);
}
