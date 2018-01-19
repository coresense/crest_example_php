<?php

function base64_url_encode(string $string): string
{
	return rtrim(strtr(base64_encode($string), '+/', '-_'), '=');
}

function token(string $userid, string $key): string
{
	$header = [
		'alg' => 'HS256',
		'typ' => 'JWT',
	];
	$payload = [
		'sub' => $userid,
		'exp' => time() + 3600,
	];
	$t1 = base64_url_encode(json_encode($header));
	$t2 = base64_url_encode(json_encode($payload));
	$signature = hash_hmac('sha256', $t1 . '.' . $t2, $key, true);
	$t3 = base64_url_encode($signature);
	return $t1 . '.' . $t2 . '.' . $t3;
}
