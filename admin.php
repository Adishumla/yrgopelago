<?php

declare(strict_types=1);

session_start(
  [
    'cookie_lifetime' => 360,
  ]
);

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
$db = new PDO('sqlite:database/identifier.sqlite');
//fetch all id from luxury table
$luxury_id = $db->query("SELECT id FROM luxury")->fetchAll(PDO::FETCH_COLUMN);
$luxury_name = $db->query("SELECT name FROM luxury")->fetchAll(PDO::FETCH_COLUMN);
$luxury_start_date = $db->query("SELECT start_date FROM luxury")->fetchAll(PDO::FETCH_COLUMN);
$luxury_end_date = $db->query("SELECT end_date FROM luxury")->fetchAll(PDO::FETCH_COLUMN);
$luxury_feature_id = $db->query("SELECT feature_id FROM luxury")->fetchAll(PDO::FETCH_COLUMN);

// function that can save id, name, start_date, end_date and feature_id in an array from the database that can be used in all the tables
function getTableData($db, $room_type)
{
  //fetch all id from $room_type table
  $id = $db->query("SELECT id FROM $room_type")->fetchAll(PDO::FETCH_COLUMN);
  //fetch all name from $room_type table
  $name = $db->query("SELECT name FROM $room_type")->fetchAll(PDO::FETCH_COLUMN);
  //fetch all start_date from $room_type table
  $start_date = $db->query("SELECT start_date FROM $room_type")->fetchAll(PDO::FETCH_COLUMN);
  //fetch all end_date from $room_type table
  $end_date = $db->query("SELECT end_date FROM $room_type")->fetchAll(PDO::FETCH_COLUMN);
  //fetch all feature_id from $room_type table
  $feature_id = $db->query("SELECT feature_id FROM $room_type")->fetchAll(PDO::FETCH_COLUMN);
  return [$id, $name, $start_date, $end_date, $feature_id];
}

$standard = getTableData($db, 'standard');
$budget = getTableData($db, 'budget');
$luxury = getTableData($db, 'luxury');

// get price from env fille and save it so it can be cha
