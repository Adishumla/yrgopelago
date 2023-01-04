<?php

declare(strict_types=1);
session_start(
  [
    'cookie_lifetime' => 120,
  ]
);


// if checkbox is checked, set session variable to true else false, as a function of isset


use GuzzleHttp\Client;

include_once __DIR__ . '/vendor/autoload.php';

$url = 'https://www.yrgopelago.se/';
$url_withdraw = 'https://www.yrgopelago.se/centralbank/transferCode';

$transferCode = $_SESSION['transferCode'];
$totalcost = $_SESSION['totalcost'];

$client = new Client([
  'base_uri' => $url,
]);
$res = $client->request('POST', $url_withdraw, [
  'form_params' => [
    'transferCode' => $transferCode,
    'totalcost' => $totalcost,
  ],
]);

$data = json_decode($res->getBody()->getContents(), true);
if (isset($data['amount'])) {
  $amount = $data['amount'];
}
if (isset($data['error'])) {
  $error = $data['error'];
}
if ($res->getStatusCode() == 200 && !isset($error) && $amount >= $totalcost) {
  echo "Transfer successful";
  header('Location: deposit.php');
} else {
  echo "Transfer failed";
}
