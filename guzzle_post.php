<?php

$userId = '<your user id>';
$apiKey = '<your api key>';
$apiUrl = '<your api url>';

require_once 'functions.php';
require_once 'vendor/autoload.php';

$client = new \GuzzleHttp\Client();
try {
	$res = $client->request('POST', $apiUrl . '/v1/category?fields=id,category,label', [
		'headers' => [
			'X-Auth-Token' => token($userId, $apiKey),
		],
		'json' => [
			'category' => 'foo',
			'label' => 'bar',
			'active' => true,
		],
	]);
	print_r(json_decode($res->getBody(), true));
} catch (\GuzzleHttp\Exception\ClientException $e) {
	echo "request completed but response contained an error\n";
	echo $e->getMessage();
} catch (\GuzzleHttp\Exception\GuzzleException $e) {
	echo "request failed\n";
	echo $e->getMessage();
}
