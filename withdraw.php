<?php


declare(strict_types=1);
session_start(
    [
        'cookie_lifetime' => 120,
    ]
);

use GuzzleHttp\Client;

include_once __DIR__ . '/vendor/autoload.php';

$url = 'https://www.yrgopelago.se/';
$url_withdraw = 'https://www.yrgopelago.se/centralbank/withdraw';

/* if (!isset($_SESSION['transferCode'])) {
    $_SESSION['transferCode'] = $_POST['transferCode'];
} */
/* $totalcost = $_SESSION['totalcost']; */
$_SESSION['username'] = $_POST['username'];
$_SESSION['api_key'] = $_POST['api_key'];
$_SESSION['amount'] = $_POST['amount'];

$client = new Client([
    'base_uri' => $url,
]);

$res = $client->request('POST', $url_withdraw, [
    'form_params' => [
        'user' => $_SESSION['username'],
        'api_key' => $_SESSION['api_key'],
        'amount' => $_SESSION['amount'],
    ],
]);

$data = json_decode($res->getBody()->getContents(), true);
header('application/json');
var_dump(json_encode($data));
if (isset($data['tranferCode'])) {
    $_SESSION['transferCode'] = $data['transferCode'];
}
if (isset($data['amount'])) {
    $amount = $data['amount'];
}
if (isset($data['error'])) {
    $error = $data['error'];
}

if ($res->getStatusCode() == 200 && !isset($error)) {
    echo "Withdraw successful";
    $_SESSION['transferCode'] = $data['transferCode'];
    echo $_SESSION['transferCode'];
    header('Location: deposit.php');
} else {
    echo "Withdraw failed";
}
