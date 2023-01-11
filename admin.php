<link rel="stylesheet" href="css/admin.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<?php

/* declare(strict_types=1); */

session_start(
  [
    'cookie_lifetime' => 1360,
  ]
);

use Dotenv\Dotenv;

require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

if (isset($_POST['api_key'])) {
  if ($_POST['api_key'] == $_ENV['API_KEY']) {
  } else {
    echo '<script>window.location.href ="admin.php";</script>';
  }
} else {
  echo '<script>window.location.href ="index.php";</script>';
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
$money_made = $db->query("SELECT amount FROM booking")->fetchAll(PDO::FETCH_ASSOC);
$money_made = array_column($money_made, 'amount');
$money_made = array_sum($money_made);
echo '<h3>Money made: ' . $money_made . '</h3>';

// get hotel_info from database
$hotel_info = $db->query("SELECT * FROM hotel_info")->fetchAll(PDO::FETCH_ASSOC);

foreach ($hotel_info as $info) {
  echo '<form action="admin.php" method="post">';
  echo '<input type="text" name="island" value="' . $info['island'] . '">';
  echo '<input type="text" name="hotel" value="' . $info['hotel'] . '">';
  echo '<input type="number" name="stars" value="' . $info['stars'] . '">';
  echo '<input type="text" name="additional_info" value="' . $info['additional_info'] . '">';
  echo '<input type="submit" name="submit_info" value="Update">';
  echo '</form>';
}


// update hotel_info table
if (isset($_POST['submit_info'])) {
  $db->query("UPDATE hotel_info SET island = '$_POST[island]', hotel = '$_POST[hotel]', stars = '$_POST[stars]', additional_info = '$_POST[additional_info]' WHERE id = '1'");
  echo '<script>window.location.href = "admin.php";</script>';
}

$prices = getPrices($db, 'prices');

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

// get all feature_prices table data from database
$feature_prices = $db->query("SELECT * FROM feature_prices")->fetchAll(PDO::FETCH_ASSOC);

// input form for feature_prices (name, price, discount) that send query to database to update feature_prices table
foreach ($feature_prices as $feature_price) {
  echo '<form action="admin.php" method="post">';
  echo '<input type="text" name="name" value="' . $feature_price['name'] . '">';
  echo '<input type="number" name="price" value="' . $feature_price['price'] . '">';
  echo '<input type="submit" name="submit_feature_prices" value="Update">';
  echo '</form>';
}

// update feature_prices table
if (isset($_POST['submit_feature_prices'])) {
  $db->query("UPDATE feature_prices SET name = '$_POST[name]', price = '$_POST[price]' WHERE name = '$_POST[name]'");
  echo '<script>window.location.href = "admin.php";</script>';
}

// function that get room_type and then get calander.php
function getCalander($db, $room_type)
{
  $_SESSION['room_type'] = $room_type;
  include 'calander.php';
}

// get all calander from database
echo '<h1>Luxury</h1>';
getCalander($db, 'luxury');
echo '<h1>Standard</h1>';
getCalander($db, 'standard');
echo '<h1>budget</h1>';
getCalander($db, 'budget');

function getTable($db, $room_type)
{
  $table = $db->query("SELECT * FROM $room_type")->fetchAll(PDO::FETCH_ASSOC);
  $feature = $db->query("SELECT * FROM feature")->fetchAll(PDO::FETCH_ASSOC);
  echo '<table>';
  echo '<tr>';
  echo '<th>id</th>';
  echo '<th>name</th>';
  echo '<th>start_date</th>';
  echo '<th>end_date</th>';
  echo '<th>breakfast</th>';
  echo '<th>massage</th>';
  echo '<th>butler</th>';
  echo '</tr>';
  foreach ($table as $row) {
    echo '<tr>';
    echo '<td>' . $row['id'] . '</td>';
    echo '<td>' . $row['name'] . '</td>';
    echo '<td>' . $row['start_date'] . '</td>';
    echo '<td>' . $row['end_date'] . '</td>';
    foreach ($feature as $row2) {
      if ($row['feature_id'] == $row2['id']) {
        echo '<td>' . ($row2['breakfast'] == 1 ? 'yes' : 'no') . '</td>';
        echo '<td>' . ($row2['massage'] == 1 ? 'yes' : 'no') . '</td>';
        echo '<td>' . ($row2['butler'] == 1 ? 'yes' : 'no') . '</td>';
      }
    }
    echo '</tr>';
  }
  echo '</table>';
}

echo '<h1>Luxury</h1>';
getTable($db, 'luxury');
echo '<h1>Standard</h1>';
getTable($db, 'standard');
echo '<h1>budget</h1>';
getTable($db, 'budget');
?>
<section>
</section>
