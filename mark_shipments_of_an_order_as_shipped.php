<?php

// This looks up the unshipped shipments for an existing order and marks them as shipped.

$userId = '<your user id>';
$apiKey = '<your api key>';
$apiUrl = '<your api url>';

require_once 'functions.php';
require_once 'vendor/autoload.php';

$orderId = 12345;

$client = new \GuzzleHttp\Client();
try {

	// Get the shipments for this order that aren't already in a shipped status
	$res = $client->request('GET', $apiUrl . '/v1/order/' . $orderId . '/shipment?fields=id&q=status!=shipped', [
		'headers' => [
			'X-Auth-Token' => token($userId, $apiKey),
		],
	]);
	$shipments = json_decode($res->getBody(), true);

	// Iterate over the shipments, updating the status and ship_date.
	foreach ($shipments as $shipment) {
		$client->request('PUT', $apiUrl . '/v1/shipment/' . $shipment['id'], [
			'headers' => [
				'X-Auth-Token' => token($userId, $apiKey),
			],
			'json' => json_encode([
				'status' => 'shipped',
				'ship_date' => date('c'),
			]),
		]);
	}

} catch (\GuzzleHttp\Exception\ClientException $e) {
	echo "request completed but response contained an error\n";
	echo $e->getMessage();
} catch (\GuzzleHttp\Exception\GuzzleException $e) {
	echo "request failed\n";
	echo $e->getMessage();
}
