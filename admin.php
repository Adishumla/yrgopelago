<?php

declare(strict_types=1);

session_start(
  [
    'cookie_lifetime' => 1360,
  ]
);

//function that that takes session variable and include calander.php
function include_calander()
{
  if (isset($_SESSION['transferCode'])) {
    include __DIR__ . '/calander.php';
  }
}
function getCalander($room_type)
{
  $_SESSION['room_type'] = $room_type;
  include __DIR__ . '/calander.php';
}



use Dotenv\Dotenv;

require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

if (isset($_POST['api_key'])) {
  if ($_POST['api_key'] == $_ENV['API_KEY']) {
    echo 'Welcome admin';
  } else {
    header('Location: index.php');
  }
} else {
  header('Location: index.php');
}

// get all luxury table data from database
$db = new PDO('sqlite:' . __DIR__ . '/database/identifier.sqlite');
//fetch all id from luxury table
$luxury_id = $db->query("SELECT id FROM luxury")->fetchAll(PDO::FETCH_COLUMN);
$luxury_name = $db->query("SELECT name FROM luxury")->fetchAll(PDO::FETCH_COLUMN);
$luxury_start_date = $db->query("SELECT start_date FROM luxury")->fetchAll(PDO::FETCH_COLUMN);
$luxury_end_date = $db->query("SELECT end_date FROM luxury")->fetchAll(PDO::FETCH_COLUMN);
$luxury_feature_id = $db->query("SELECT feature_id FROM luxury")->fetchAll(PDO::FETCH_COLUMN);

// function to get data from prices table (name, price, discount)
function getPrices($db, $room_type)
{
  $prices = $db->query("SELECT name, price, discount FROM $room_type")->fetchAll(PDO::FETCH_ASSOC);
  return $prices;
}

// get all prices from database
$prices = getPrices($db, 'prices');
/* echo '<pre>';
print_r($prices);
echo '</pre>';
 */
// input form for each room type (name, price, discount) that send query to database to update prices table
foreach ($prices as $price) {
  echo '<form action="admin.php" method="post">';
  echo '<input type="text" name="name" value="' . $price['name'] . '">';
  echo '<input type="number" name="price" value="' . $price['price'] . '">';
  echo '<input type="number" name="discount" value="' . $price['discount'] . '">';
  echo '<input type="submit" name="submit" value="Update">';
  echo '</form>';
}

// update prices table
if (isset($_POST['submit'])) {
  $db->query("UPDATE prices SET name = '$_POST[name]', price = '$_POST[price]', discount = '$_POST[discount]' WHERE name = '$_POST[name]'");
  echo '<script>window.location.href = "admin.php";</script>';
}
