<?php

// This creates a new order.

$userId = '<your user id>';
$apiKey = '<your api key>';
$apiUrl = '<your api url>';

require_once 'functions.php';
require_once 'vendor/autoload.php';

$data = [

	// This is the customer's ID. If this order is for a new customer, the
	// customer record must first be created via the POST /v1/customer endpoint.
	'customer_id' => 12345,

	// The ID of the contact that the order will be billed to. If omitted,
	// the customer's default billing contact will be used.
	'billing_contact_id' => 234,

	// The ID of the sales channel to attribute to order to. These can be
	// enumerated via the GET /v1/channel endpoint.
	'channel_id' => 1,

	// An array of items to place on the order.
	'items' => [
		[

			// Required. The ID of the product to order. These can be enumerated via
			// the GET /v1/product endpoint.
			'product_id' => 123,

			// Required. The ID of the shipping method that this item will use. These
			// can be enumerated via the GET /v1/shippingMethod endpoint.
			'shipping_method_id' => 7,

			// Optional. The quantity to order. If omitted, defaults to 1.
			'quantity' => 1,

			// Optional. The unit price for this item. If omitted, defaults to the
			// product's price set for the indicated channel.
			'unit_price' => 1.23,

			// Optional. The ID of the contact that this item will be shipped to.
			// If omitted, the customer's default shipping contact will be used.
			'shipping_contact_id' => 789,

			// Optional. If provided, source the items from this warehouse. These can
			// be enumerated via the GET /v1/warehouse endpoint. If this value is not
			// provided, your existing sourcing rules will be used.
			'warehouse_id' => 2,

		],
		[
			'product_id' => 456,
			'quantity' => 2,
			'warehouse_id' => 3,
		],
	],
];

$client = new \GuzzleHttp\Client();
try {
	$res = $client->request('POST', $apiUrl . '/v1/customer', [
		'headers' => [
			'X-Auth-Token' => token($userId, $apiKey),
		],
		'json' => $data,
	]);
	print_r(json_decode($res->getBody(), true));
} catch (\GuzzleHttp\Exception\ClientException $e) {
	echo "request completed but response contained an error\n";
	echo $e->getMessage();
} catch (\GuzzleHttp\Exception\GuzzleException $e) {
	echo "request failed\n";
	echo $e->getMessage();
}
