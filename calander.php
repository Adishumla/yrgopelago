<?php
include 'functions.php';
$room_type = $_SESSION['room_type'];
getDates($db, $room_type);
//if session_error is set, echo the error
if (isset($_SESSION['error'])) {
  echo $_SESSION['error'];
}
// only vardump start_dates from function getDates($db, $room_type)
/* var_dump(getDates($db, 'standard')[0]);
  // only vardump end_dates from function getDates($db, $room_type)
  var_dump(getDates($db, 'standard')[1]); */
$start_dates = getDates($db, $room_type)[0];
$end_dates = getDates($db, $room_type)[1];
// booked days are the days between the start_date and end_date
$booked_days = array();
// loop through the start_dates and end_dates
for ($i = 0; $i < count($start_dates); $i++) {
  // loop through the days between the start_date and end_date
  for ($j = $start_dates[$i]; $j <= $end_dates[$i]; $j++) {
    // save the days between the start_date and end_date in an array
    $booked_days[] = $j;
  }
}
// save every day of january in an array 2023-01-01 to 2023-01-31 (01 to 31)
$january = array();
for ($i = 1; $i <= 31; $i++) {
  // add a 0 to the days that are less than 10
  if ($i < 10) {
    $january[] = '2023-01-0' . $i;
  } else {
    $january[] = '2023-01-' . $i;
  }
}

// color the days that are booked in red
echo '<div>';
echo '<h1>january</h1>';
for ($i = 0; $i < count($january); $i++) {
  if (in_array($january[$i], $booked_days)) {
    echo '<span style="color:red">' . $january[$i] . '</span>';
    echo '<br>';
  } else {
    echo $january[$i];
    echo '<br>';
  }
}
echo '</div>';
