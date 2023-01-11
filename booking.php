<?php

use function PHPSTORM_META\type;

/* session_start(
  [
    'cookie_lifetime' => 240,
  ]
); */

header('Content-Type: application/json');

//get data from database
$db = new PDO('sqlite:' . __DIR__ . '/database/identifier.sqlite');
// get last id from database table $_SESSION['room_type']
$last_feature_id = $db->query("SELECT id FROM feature ORDER BY id DESC LIMIT 1")->fetchColumn();
$last_room_id = $db->query("SELECT id FROM $_SESSION[room_type] ORDER BY id DESC LIMIT 1")->fetchColumn();

//get all info from hotel_info table
$hotel_info = $db->query("SELECT * FROM hotel_info")->fetch(PDO::FETCH_ASSOC); //island, hotel, stars, additional_info

/* echo $last_room_id = $last_room_id + 1;
echo gettype($last_room_id);
echo '<br>';
echo $last_feature_id = (int) $last_feature_id + 1;
echo gettype($last_feature_id); */
//insert data into database
$db->query("INSERT INTO $_SESSION[room_type] (name, start_date, end_date, feature_id) VALUES ('$_SESSION[username]', '$_SESSION[start_date]', '$_SESSION[end_date]', $last_feature_id + 1)");
$db->query("INSERT INTO feature (name, room_id, butler, breakfast, massage, room_type) VALUES ('$_SESSION[username]', $last_room_id + 1, '$_SESSION[butler]', '$_SESSION[breakfast]', '$_SESSION[massage]', '$_SESSION[room_type]')");
$db->query("INSERT INTO booking (name, amount, room_type, room_id) VALUES ('$_SESSION[username]', '$_SESSION[totalcost]', '$_SESSION[room_type]', $last_room_id + 1)");
echo 'booking successful!';
//echo '<script>setTimeout(function(){window.location.href = "' . $_SESSION['room_type'] . '.php";}, 4000);</script>';

$features = [];
if ($_SESSION['butler'] == 1) {
  array_push($features, 'butler');
}
if ($_SESSION['breakfast'] == 1) {
  array_push($features, 'breakfast');
}
if ($_SESSION['massage'] == 1) {
  array_push($features, 'massage');
}

$features = implode(', ', $features);

$booking = [
  'island' => $hotel_info['island'],
  'hotel' => $hotel_info['hotel'],
  'arrival_date' => $_SESSION['start_date'],
  'departure_date' => $_SESSION['end_date'],
  'total_cost' => round($_SESSION['totalcost'], 3),
  'room_type' => $_SESSION['room_type'],
  'stars' => $hotel_info['stars'],
  // 'features' => name $features and cost: $_SESSION['feature_cost]
  'features' => ['name' =>  $features, 'cost' => $_SESSION['feature_cost']],
  'additional_info' => $hotel_info['additional_info'],
];

file_put_contents('booking.json', json_encode($booking, JSON_PRETTY_PRINT));
echo json_encode($booking, JSON_PRETTY_PRINT);
