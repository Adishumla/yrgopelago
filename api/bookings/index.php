<?php

declare(strict_types=1);

session_start(
  [
    'cookie_lifetime' => 360,
  ]
);

header('Content-Type: application/json');

// wait for user to post data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // get data from post

  $data = [];
  $error = [];

  if (isset($_POST['username'])) {
    htmlspecialchars($_POST['username'], ENT_QUOTES, 'UTF-8');
    $data['username'] = $_POST['username'];
  } else {
    $error['username'] = 'Username is missing';
  }

  if (isset($_POST['transferCode'])) {
    htmlspecialchars($_POST['transferCode'], ENT_QUOTES, 'UTF-8');
    $data['transferCode'] = $_POST['transferCode'];
  } else {
    $error['transferCode'] = 'TransferCode is missing';
  }
  if (isset($_POST['start_date']) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $_POST['start_date']) && date($_POST['start_date']) > date('2023-01-01') && date($_POST['start_date']) < date('2023-01-31') && date($_POST['start_date']) < date($_POST['end_date'])) {
    $data['start_date'] = date($_POST['start_date']);
  } else {
    $error['start_date'] = 'Start date is missing';
  }
  // check if end_date is set and if it matches the format YYYY-MM-DD and check if date is in 2023 and january from 1 to 31
  if (isset($_POST['end_date']) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $_POST['end_date']) && date($_POST['end_date']) > date('2023-01-01') && date($_POST['end_date']) < date('2023-01-31') && date($_POST['end_date']) > date($_POST['start_date'])) {
    $data['end_date'] = date($_POST['end_date']);
  } else {
    $error['end_date'] = 'End date is missing';
  }
  // if butler is 1, then set it to 1, else set it to 0 int
  if (isset($_POST['butler']) && $_POST['butler'] == 1) {
    $data['butler'] = (int)$_POST['butler'];
  } else {
    $data['butler'] = 0;
  }

  if (isset($_POST['massage']) && $_POST['massage'] == 1) {
    $data['massage'] = (int)$_POST['massage'];
  } else {
    $data['massage'] = 0;
  }

  if (isset($_POST['breakfast']) && $_POST['breakfast'] == 1) {
    $data['breakfast'] = (int)$_POST['breakfast'];
  } else {
    $data['breakfast'] = 0;
  }
  // room is a string and can be any of the following values luxury, standard, budget
  if (isset($_POST['room_type']) && ($_POST['room_type'] == 'luxury' || $_POST['room_type'] == 'standard' || $_POST['room_type'] == 'budget')) { // could also use in_array here pointing to db to make dynamic (NO TIME!)
    $data['room_type'] = $_POST['room_type'];
  } else {
    $error['room_type'] = 'Room type is missing';
  }

  if (count($error) > 0) {
    echo json_encode($error);
  } else {
    $_SESSION['username'] = $data['username'];
    $_SESSION['transferCode'] = $data['transferCode'];
    $_SESSION['start_date'] = $data['start_date'];
    $_SESSION['end_date'] = $data['end_date'];
    $_SESSION['butler'] = $data['butler'];
    $_SESSION['massage'] = $data['massage'];
    $_SESSION['breakfast'] = $data['breakfast'];
    $_SESSION['room_type'] = $data['room_type'];
    json_encode($data);
    include_once __DIR__ . '/../../booking_status.php';
  }
}
