<?php

// Given a barcode string, lookup product details, SKU
// requirements, SKU details, and on-hand inventory.

$userId = '<your user id>';
$apiKey = '<your api key>';
$apiUrl = '<your api url>';

require_once 'functions.php';
require_once 'vendor/autoload.php';

// Look up a barcode by its barcode string. We'll hit this URL: /v1/barcode?q=barcode=<barcode_string>
// Note this will always return an array, even if there's only one result.
$barcodeString = '34-0425-DMXP12';
$searchResults = get($apiUrl . '/v1/barcode?q=barcode=' . urlencode($barcodeString), $userId, $apiKey);
if (count($searchResults) !== 1) {
	echo "Expected one record\n";
	exit;
}
echo "Barcode:\n";
$barcode = array_shift($searchResults);
print_r($barcode);

// $barcode now contains:
// {
//    "barcode": "34-0425-DMXP12",
//    "id": 4,
//    "product_id": 1,
//    "stamp": "2015-06-24T09:43:53-04:00"
// }

// Now we have the product ID for the barcode, we can look up the product details.
// We'll hit this URL: /v1/product/<product_id>
// Where <product_id> is $barcode['product_id'] from the barcode query.
$product = get($apiUrl . '/v1/product/' . $barcode['product_id'], $userId, $apiKey);
echo "Product:\n";
print_r($product);

// We can also look up the SKUs that make up the product. We'll query the barcodeSku
// endpoint with a filter on the barcode id we got from the previous query.
// We'll use this URL: /v1/barcodeSku?q=barcode_id=<barcode_id>
// Where <barcode_id> is $barcode['id'] from the barcode query.
// Note this will return an array even if the product is made up of only one SKU.
$skus = get($apiUrl . '/v1/barcodeSku?q=barcode_id=' . $barcode['id'], $userId, $apiKey);
echo "SKUs:\n";
foreach ($skus as $sku) {
	print_r($sku);
}

// Now that we have the SKUs that make up the item, we can lookup the detail for each SKU.
// We'll hit this URL: /v1/sku/<sku_id>
// Where <sku_id> is $sku['sku_id'] from the SKU query.
echo "SKU detail:\n";
foreach ($skus as $sku) {
	$skuDetail = get($apiUrl . '/v1/sku/' . $sku['sku_id'], $userId, $apiKey);
	print_r($skuDetail);
}

// And we can look up the available inventory for each SKU.
// We'll hit this URL: /v1/skuInventory/<sku_id>?q=status=unassigned
// Where <sku_id> is $sku['sku_id'] from the SKU query.
// Note the filter on status because we want to exclude reserved and assigned inventory.
echo "SKU inventory:\n";
foreach ($skus as $sku) {
	$skuInventory = get($apiUrl . '/v1/skuInventory/' . $sku['sku_id'] . '?q=status=unassigned', $userId, $apiKey);
	print_r($skuInventory);
}
