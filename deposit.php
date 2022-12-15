<?php

declare(strict_types=1);
session_start(
    [
        'cookie_lifetime' => 240,
    ]
);

use GuzzleHttp\Client;

include_once __DIR__ . '/vendor/autoload.php';

$url = 'https://www.yrgopelago.se/';
$url_deposit = 'https://www.yrgopelago.se/centralbank/deposit';

/* $_SESSION['transferCode'];*/
/* $_SESSION['totalcost'];
$_SESSION['username']; // should be my username so that i receive the money */

/* if (isset($_SESSION['transferCode'])) {
    $transferCode = $_SESSION['transferCode'];
} else {
    $transferCode = $_POST['transferCode'];
} */

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
header('application/json');
var_dump(json_encode($data));
if (isset($data['error'])) {
    $error = $data['error'];
}
if (isset($data['message'])) {
    $message = $data['message'];
}

if ($res->getStatusCode() == 200 && !isset($error)) {
    echo "Deposit successful";
} else {
    echo "Deposit failed";
}
