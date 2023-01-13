<?php

declare(strict_types=1);

$db = new PDO('sqlite:' . __DIR__ . '/database/identifier.sqlite');
// save every start_date and end_date in an array from the database function getDates($db, $room_type)
function getDates($db, $room_type)
{
  //save all the start_dates in an array
  $start_dates = $db->query("SELECT start_date FROM $room_type ORDER BY id ASC")->fetchAll(PDO::FETCH_COLUMN);
  //save all the end_dates in an array
  $end_dates = $db->query("SELECT end_date FROM $room_type ORDER BY id ASC")->fetchAll(PDO::FETCH_COLUMN);
  return [$start_dates, $end_dates];
}

function checkbox($checkbox)
{
  if (isset($_POST[$checkbox])) {
    $_SESSION[$checkbox] = 1;
  } else {
    $_SESSION[$checkbox] = 0;
  }
}
