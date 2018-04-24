<?php

// This creates a new customer and two new contacts via a single POST.
//
// If you omit the default_shipping_contact and provide only the
// default_billing_contact, then the data in default_billing_contact
// will be used for default_shipping_contact as well.
//
// Note there are many fields on the customer record, almost all of
// which are optional. You can perform a GET query on the /v1/customer
// endpoint to see an example of all the fields that are defined for
// your particular implementation.

$apiUrl = 'https://api-<your domain>.coresense.com/v1/customer';
$userId = '<your user id>';
$apiKey = '<your api key>';

require_once 'functions.php';
require_once 'vendor/autoload.php';

$data = [
//	'affiliate_id' => '1', // Optional. From the affiliates table, available via the /v1/affiliate endpoint.
	'originating_brand_id' => '1', // Required. From the brands table, available via the /v1/brand endpoint.
	'default_billing_contact' => [
		'label' => 'home',
		'active' => true,
		'first_name' => 'Joe',
		'last_name' => 'Smith',
		'address_line_1' => '123 Main St.',
		'address_line_2' => 'Apt. 1A',
		'city' => 'Gotham',

		// Provide one of the following:
//		'state_id' => '46',
		'state' => 'NY',
//		'state' => 'New York',

		'postal_code' => '12345',

		// Provide one of the following:
//		'country_id' => '1',
		'country' => 'US',
//		'country' => 'United States',

		'phone' => '123-456-7890',
		'email' => 'joe@smith.com',
	],
	'default_shipping_contact' => [
		'label' => 'work',
		'active' => true,
		'first_name' => 'Joe',
		'last_name' => 'Smith',
		'address_line_1' => '456 Side St.',
		'city' => 'Gotham',

		// Provide one of the following:
//		'state_id' => '46',
		'state' => 'NY',
//		'state' => 'New York',

		'postal_code' => '12345',

		// Provide one of the following:
//		'country_id' => '1',
		'country' => 'US',
//		'country' => 'United States',

		'phone' => '123-456-7890',
		'email' => 'joe@smith.com',
	],
];

$client = new \GuzzleHttp\Client();
try {
	$res = $client->request('POST', $apiUrl, [
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
