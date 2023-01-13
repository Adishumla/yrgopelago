<?php

declare(strict_types=1);

use GuzzleHttp\Client;

include_once __DIR__ . '/vendor/autoload.php';

$url = 'https://www.yrgopelago.se/';
$url_deposit = 'https://www.yrgopelago.se/centralbank/deposit';

$client = new Client([
  'base_uri' => $url,
]);

$res = $client->request('POST', $url_deposit, [
  'form_params' => [
    'user' => 'adam',
    'transferCode' => $_SESSION['transferCode'],
  ],
]);

$data = json_decode($res->getBody()->getContents(), true);

if (isset($data['error'])) {
  $error = $data['error'];
}
if (isset($data['message'])) {
  $message = $data['message'];
}

if ($res->getStatusCode() == 200 && !isset($error)) {

  require_once 'booking.php';
} else {
  echo "Deposit failed";
}
