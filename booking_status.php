<?php
session_start(
  [
    'cookie_lifetime' => 240,
  ]
);

include 'functions.php';
$room_type = 'standard';
getDates($db, $room_type);

$_SESSION['start_date'] = $_POST['start_date'];
$_SESSION['end_date'] = $_POST['end_date'];

$start_dates = getDates($db, 'standard')[0];
$end_dates = getDates($db, 'standard')[1];
$booked_days = array();
// loop through the start_dates and end_dates
for ($i = 0; $i < count($start_dates); $i++) {
  // loop through the days between the start_date and end_date
  for ($j = $start_dates[$i]; $j <= $end_dates[$i]; $j++) {
    // save the days between the start_date and end_date in an array
    $booked_days[] = $j;
  }
}
// check if user is trying to book a booked day and if so, show an error message from $_Session['start_date'] and $_Session['end_date']
if (in_array($_SESSION['start_date'], $booked_days) || in_array($_SESSION['end_date'], $booked_days)) {
  $_SESSION['error'] = 'The room is not available for the selected dates';
  header('Location:' . $_SESSION['room_type'] . '.php');
} else {
  echo 'this room is available';
}
