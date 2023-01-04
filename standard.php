<?php
session_start(
  [
    'cookie_lifetime' => 120,
  ]
);

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>form</title>
</head>
<style>
  body {
    height: 100vh;
    display: flex;
    flex-direction: row;
    justify-content: center;
    gap: 100px;
  }

  section {
    display: flex;
    flex-direction: column;
    align-items: center;
  }

  form {
    display: flex;
    flex-direction: column;
    align-items: center;
  }

  input {
    margin: 10px;
  }
</style>

<body>
  <section>
    <h1>standard</h1>
    <form action="booking_status.php" method="post">
      <label for="username">username</label>
      <input name="username" type="text">
      <label for="transferCode">transferCode</label>
      <input name="transferCode" type="text">
      <label for="totalcost">totalcost</label>
      <input name="totalcost" type="number">
      <label for="start date">start date</label>
      <input name="start date" type="date" min="2023-01-01" max="2023-01-31">
      <label for=" end date">end date</label>
      <input name="end date" type="date" min="2023-01-01" max="2023-01-31">
      <label for="butler">butler</label>
      <input name="butler" type="checkbox">
      <label for="massage">massage</label>
      <input name="massage" type="checkbox">
      <label for="breakfast">breakfast</label>
      <input name="breakfast" type="checkbox">
      <?php $_SESSION['room_type'] = 'standard'; ?>
      <input type="submit">
  </section>
  <?php
  include 'functions.php';
  getDates($db, 'standard');
  //if session_error is set, echo the error
  if (isset($_SESSION['error'])) {
    echo $_SESSION['error'];
  }
  // only vardump start_dates from function getDates($db, $room_type)
  /* var_dump(getDates($db, 'standard')[0]);
  // only vardump end_dates from function getDates($db, $room_type)
  var_dump(getDates($db, 'standard')[1]); */
  $start_dates = getDates($db, 'standard')[0];
  $end_dates = getDates($db, 'standard')[1];
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
  ?>
</body>

</html>
