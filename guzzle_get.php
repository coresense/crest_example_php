<?php

$apiUrl = 'https://api-<your domain>.coresense.com/v1/category?fields=id,category,label';
$userId = '<your user id>';
$apiKey = '<your api key>';

require_once 'functions.php';
require_once 'vendor/autoload.php';

$client = new \GuzzleHttp\Client();
try {
	$res = $client->request('GET', $apiUrl, [
		'headers' => [
			'X-Auth-Token' => token($userId, $apiKey),
			'Content-Type' => 'application/json',
		],
	]);
	foreach (json_decode($res->getBody(), true) as $row) {
		print_r($row);
	}
} catch (\GuzzleHttp\Exception\ClientException $e) {
	echo "request completed but response contained an error\n";
	echo $e->getMessage();
} catch (\GuzzleHttp\Exception\GuzzleException $e) {
	echo "request failed\n";
	echo $e->getMessage();
}
