<?php

$userId = '<your user id>';
$apiKey = '<your api key>';
$apiUrl = '<your api url>';

require_once 'functions.php';
require_once 'vendor/autoload.php';

$client = new \GuzzleHttp\Client();
try {
	$res = $client->request('GET', $apiUrl . '/v1/category?fields=id,category,label', [
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
