<?php

// This assumes that you've already got a valid customer record and you know
// its ID.
//
// The state_id and country_id fields are expected to contain integer IDs from
// the states and countries tables in your database. You can see these values
// in the Technical Configuration Manager or by querying the /v1/state and
// /v1/country endpoints.
//
// Alternatively, instead of providing the ID in the state_id field, you may
// provide the state abbreviation or name in the state field. You should
// provide either state or state_id, but not both. Likewise, you may also
// provide the country abbreviation or name in the country field.
//
// Note: If you choose to provide state name instead of state_id, or country
// name instead of country_id, then the values you provide must match the
// values in your database.

$apiUrl = 'https://api-<your domain>.coresense.com/v1/contact';
$userId = '<your user id>';
$apiKey = '<your api key>';

require_once 'functions.php';
require_once 'vendor/autoload.php';

$data = [
	'customer_id' => '123', // This is the existing customer's ID.
	'label' => 'home',
	'active' => true,
	'first_name' => 'Joe',
	'last_name' => 'Smith',
	'address_line_1' => '123 Main St.',
	'address_line_2' => 'Apt. 1A',
	'city' => 'Gotham',

	// Provide one of the following:
//	'state_id' => '46',
//	'state' => 'NY',
	'state' => 'New York',

	'postal_code' => '12345',

	// Provide one of the following:
//	'country_id' => '1',
//	'country' => 'US',
	'country' => 'United States',

	'phone' => '123-456-7890',
	'email' => 'joe@smith.com',
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
