<?php

$userId = '<your user id>';
$apiKey = '<your api key>';
$apiUrl = '<your api url>';

require_once 'functions.php';
require_once 'vendor/autoload.php';

$client = new \GuzzleHttp\Client();
try {
	$res = $client->request('PUT', $apiUrl . '/v1/category/1', [
		'headers' => [
			'X-Auth-Token' => token($userId, $apiKey),
		],
		'json' => [
			'category' => 'foo',
			'label' => 'bar',
			'active' => true,
		],
	]);
	echo "request succeeded\n";
} catch (\GuzzleHttp\Exception\ClientException $e) {
	echo "request completed but response contained an error\n";
	echo $e->getMessage();
} catch (\GuzzleHttp\Exception\GuzzleException $e) {
	echo "request failed\n";
	echo $e->getMessage();
}
