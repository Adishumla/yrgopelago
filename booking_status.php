<?php
session_start(
  [
    'cookie_lifetime' => 240,
  ]
);

include 'functions.php';
$room_type = $_SESSION['room_type'];
getDates($db, $room_type);

$_SESSION['start_date'] = $_POST['start_date'];
$_SESSION['end_date'] = $_POST['end_date'];

$start_dates = getDates($db, $room_type)[0];
$end_dates = getDates($db, $room_type)[1];
$booked_days = array();
// loop through the start_dates and end_dates
for ($i = 0; $i < count($start_dates); $i++) {
  // loop through the days between the start_date and end_date
  for ($j = $start_dates[$i]; $j <= $end_dates[$i]; $j++) {
    // save the days between the start_date and end_date in an array
    $booked_days[] = $j;
  }
}

// array of room_types and their prices
$prices = [
  'standard' => 2,
  'budget' => 1,
  'luxury' => 3,
];

// compare the room_type with the prices array and save the price in a variable
foreach ($prices as $key => $value) {
  if ($key == $room_type) {
    $price = $value;
  }
}


echo '<br>';
$total_cost = ((strtotime($_SESSION['end_date']) - strtotime($_SESSION['start_date'])) / 86400 + 1) * $price;
$_SESSION['total_cost'] = $total_cost;
//add the 2 for every checkbox that is checked
if (isset($_POST['breakfast'])) {
  $_SESSION['total_cost'] += 2;
}
if (isset($_POST['massage'])) {
  $_SESSION['total_cost'] += 2;
}
if (isset($_POST['butler'])) {
  $_SESSION['total_cost'] += 2;
}
// if the user booked 5 or more days, give a 10% discount
if ((strtotime($_SESSION['end_date']) - strtotime($_SESSION['start_date'])) / 86400 + 1 >= 5) {
  $_SESSION['total_cost'] = $_SESSION['total_cost'] * 0.9;
}
echo $_SESSION['total_cost'];

// check if start_date is less than end_date
if (strtotime($_SESSION['start_date']) > strtotime($_SESSION['end_date'])) {
  $_SESSION['error'] = 'The start date must be before the end date';
  header('Location:' . $_SESSION['room_type'] . '.php');
}

// check if user is trying to book a booked day and if so, show an error message from $_Session['start_date'] and $_Session['end_date']
if (in_array($_SESSION['start_date'], $booked_days) || in_array($_SESSION['end_date'], $booked_days)) {
  $_SESSION['error'] = 'The room is not available for the selected dates';
  header('Location:' . $_SESSION['room_type'] . '.php');
} else {
  echo 'this room is available';
}
