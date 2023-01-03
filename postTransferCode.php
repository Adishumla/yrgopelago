<?php

declare(strict_types=1);
session_start(
  [
    'cookie_lifetime' => 120,
  ]
);

$_SESSION['username'] = $_POST['username'];
$_SESSION['transferCode'] = $_POST['transferCode'];
$_SESSION['totalcost'] = $_POST['totalcost'];
$_SESSION['start_date'] = $_POST['start_date'];
$_SESSION['end_date'] = $_POST['end_date'];

$_SESSION['butler'] = $_POST['butler'];
$_SESSION['massage'] = $_POST['massage'];
$_SESSION['breakfast'] = $_POST['breakfast'];


use GuzzleHttp\Client;

include_once __DIR__ . '/vendor/autoload.php';

$url = 'https://www.yrgopelago.se/';
$url_withdraw = 'https://www.yrgopelago.se/centralbank/transferCode';

$transferCode = $_POST['transferCode'];
$totalcost = $_POST['totalcost'];

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
