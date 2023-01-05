<?php

// make api call to https://garali.se/api_test/
// get response
// show response

use GuzzleHttp\Client;

include_once '../../vendor/autoload.php';

$url = 'https://garali.se/api_test/';

$client = new Client([
  'base_uri' => $url,
]);

//post
$res = $client->request('POST', $url, [
  'form_params' => [
    'amount' => 100,
  ],
]);
