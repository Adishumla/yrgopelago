<?php
session_start(
  [
    'cookie_lifetime' => 1800,
  ]
);


include __DIR__ . '/functions.php';

$room_type = $_SESSION['room_type'];

$_SESSION['start_date'] = $_POST['start_date'];
$_SESSION['end_date'] = $_POST['end_date'];
htmlspecialchars($_POST['username'], ENT_QUOTES, 'UTF-8');
$_SESSION['username'] = $_POST['username'];
htmlspecialchars($_POST['transferCode'], ENT_QUOTES, 'UTF-8');
$_SESSION['transferCode'] = $_POST['transferCode'];
getDates($db, $room_type);
$start_dates = getDates($db, $room_type)[0];
$end_dates = getDates($db, $room_type)[1];

checkbox('breakfast');
checkbox('butler');
checkbox('massage');

/* echo $_POST['breakfast'];
echo '<br>';
echo $_POST['massage'];
echo '<br>';
echo $_POST['butler']; */
echo checkbox('breakfast');
echo checkbox('massage');
echo checkbox('butler');


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
  'standard' => 2,
  'budget' => 1,
  'luxury' => 3,
];

// compare the room_type with the prices array and save the price in a variable
foreach ($prices as $key => $value) {
  if ($key == $room_type) {
    $_SESSION['price'] = $value;
  }
}
echo '<script>window.location.href = "booking_status.php";</script>';
/* $total_cost = ((strtotime($_SESSION['end_date']) - strtotime($_SESSION['start_date'])) / 86400 + 1) * $_SESSION['price'];
$_SESSION['totalcost'] = $total_cost; */
/* if (isset($_SESSION['breakfast']) && isset($_SESSION['breakfast']) == 1) {
  $total_cost += 2;
}
if (isset($_SESSION['massage']) && isset($_SESSION['massage']) == 1) {
  $total_cost += 2;
}
if (isset($_SESSION['butler']) && isset($_SESSION['butler']) == 1) {
  $total_cost += 2;
} */
