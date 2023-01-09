<?php
session_start(
  [
    'cookie_lifetime' => 360,
  ]
);
/* echo 'TEST'; */
include __DIR__ . '/functions.php';
$room_type = $_SESSION['room_type'];
getDates($db, $room_type);
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
// save booked days in a session variable array
$_SESSION['booked_days'] = $booked_days;

// array of room_types and their prices
$prices = [
  'standard' => $db->query('SELECT price FROM prices WHERE name = "standard"')->fetchColumn(),
  'budget' => $db->query('SELECT price FROM prices WHERE name = "budget"')->fetchColumn(),
  'luxury' => $db->query('SELECT price FROM prices WHERE name = "luxury"')->fetchColumn(),
];

// compare the room_type with the prices array and save the price in a variable
foreach ($prices as $key => $value) {
  if ($key == $room_type) {
    $_SESSION['price'] = $value;
  }
}

//echo '<br>';
$total_cost = ((strtotime($_SESSION['end_date']) - strtotime($_SESSION['start_date'])) / 86400 + 1) * $_SESSION['price'];
//add the 2 for every checkbox that is checked
if ($_SESSION['massage'] == 1) {
  $total_cost += 2;
}
if ($_SESSION['breakfast'] == 1) {
  $total_cost += 2;
}
if ($_SESSION['butler'] == 1) {
  $total_cost += 2;
}
$_SESSION['totalcost'] = $total_cost;
// if the user booked 5 or more days, give a 10% discount
if ((strtotime($_SESSION['end_date']) - strtotime($_SESSION['start_date'])) / 86400 + 1 >= 5) {
  $_SESSION['totalcost'] = $_SESSION['totalcost'] * 0.9;
}
// check if start_date is less than end_date
if (strtotime($_SESSION['start_date']) > strtotime($_SESSION['end_date'])) {
  $_SESSION['error'] = 'The start date must be before the end date';
  header('Location:' . $_SESSION['room_type'] . '.php');
}
// check if user is trying to book a booked day and if so, show an error message from $_Session['start_date'] and $_Session['end_date']
if (in_array($_SESSION['start_date'], $_SESSION['booked_days']) || in_array($_SESSION['end_date'], $_SESSION['booked_days'])) {
  $_SESSION['error'] = 'The room is not available for the selected dates';
  echo '<script> setTimeout(function(){window.location.href = "' . $_SESSION['room_type'] . '.php";}, 3000);</script>';
} else {
  /* echo 'this room is available';
  echo '<script> setTimeout(function(){window.location.href = "postTransferCode.php";}, 5000);</script>'; */
  require_once 'postTransferCode.php';
}
