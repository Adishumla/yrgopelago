<?php

declare(strict_types=1);

session_start(
  [
    'cookie_lifetime' => 120,
  ]
);

// api that accepts post requests and returns json
header('Content-Type: application/json');

$_SESSION['username'] = $_POST['username'];
$_SESSION['transferCode'] = $_POST['transferCode'];
$_SESSION['room_type'] = $_POST['room_type'];
$_SESSION['start_date'] = $_POST['start_date'];
$_SESSION['end_date'] = $_POST['end_date'];
$_SESSION['breakfast'] = $_POST['breakfast'];
$_SESSION['butler'] = $_POST['butler'];
$_SESSION['massage'] = $_POST['massage'];

// check if all the required fields are set and not empty

//username is set and not empty and is a string
if (isset($_SESSION['username']) && !empty($_SESSION['username']) && is_string($_SESSION['username'])) {
  $username = $_SESSION['username'];
} else {
  $error = 'Username is not set or empty';
}

//transferCode is set and not empty and is a string
if (isset($_SESSION['transferCode']) && !empty($_SESSION['transferCode']) && is_string($_SESSION['transferCode'])) {
  $transferCode = $_SESSION['transferCode'];
} else {
  $error = 'TransferCode is not set or empty';
}

//room_type is set and not empty and is a string
if (isset($_SESSION['room_type']) && !empty($_SESSION['room_type']) && is_string($_SESSION['room_type'])) {
  $room_type = $_SESSION['room_type'];
} else {
  $error = 'Room type is not set or empty';
}

//start_date is set and not empty and is a date in the format YYYY-MM-DD
if (isset($_SESSION['start_date']) && !empty($_SESSION['start_date']) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $_SESSION['start_date'])) {
  $start_date = $_SESSION['start_date'];
} else {
  $error = 'Start date is not set or empty or is not in the format YYYY-MM-DD';
}

//end_date is set and not empty and is a date in the format YYYY-MM-DD
if (isset($_SESSION['end_date']) && !empty($_SESSION['end_date']) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $_SESSION['end_date'])) {
  $end_date = $_SESSION['end_date'];
} else {
  $error = 'End date is not set or empty or is not in the format YYYY-MM-DD';
}

//breakfast is set and not empty and is a boolean
if (isset($_SESSION['breakfast']) && !empty($_SESSION['breakfast']) && is_bool($_SESSION['breakfast'])) {
  $breakfast = $_SESSION['breakfast'];
} else {
  $error = 'Breakfast is not set or empty';
}

//butler is set and not empty and is a boolean
if (isset($_SESSION['butler']) && !empty($_SESSION['butler']) && is_bool($_SESSION['butler'])) {
  $butler = $_SESSION['butler'];
} else {
  $error = 'Butler is not set or empty';
}

//massage is set and not empty and is a boolean
if (isset($_SESSION['massage']) && !empty($_SESSION['massage']) && is_bool($_SESSION['massage'])) {
  $massage = $_SESSION['massage'];
} else {
  $error = 'Massage is not set or empty';
}

// if no errors
if (!isset($error)) {
  header('Location: booking_status.php');
}
