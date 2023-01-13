<?php

use function PHPSTORM_META\type;

header('Content-Type: application/json');

//get data from database
$db = new PDO('sqlite:' . __DIR__ . '/database/identifier.sqlite');
// get last id from database table $_SESSION['room_type']
$last_feature_id = $db->query("SELECT id FROM feature ORDER BY id DESC LIMIT 1")->fetchColumn();
$last_room_id = $db->query("SELECT id FROM $_SESSION[room_type] ORDER BY id DESC LIMIT 1")->fetchColumn();

//get all info from hotel_info table
$hotel_info = $db->query("SELECT * FROM hotel_info")->fetch(PDO::FETCH_ASSOC); //island, hotel, stars, additional_info

//insert data into database
$query = "INSERT INTO " . $_SESSION['room_type'] . " (name, start_date, end_date, feature_id) VALUES (?, ?, ?, ?)";
$stmt = $db->prepare($query);
$stmt->bindValue(1, $_SESSION['username'], PDO::PARAM_STR);
$stmt->bindValue(2, $_SESSION['start_date'], PDO::PARAM_STR);
$stmt->bindValue(3, $_SESSION['end_date'], PDO::PARAM_STR);
$stmt->bindValue(4, $last_feature_id + 1, PDO::PARAM_INT);
$stmt->execute();
$stmt = $db->prepare("INSERT INTO feature (name, room_id, butler, breakfast, massage, room_type) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bindValue(1, $_SESSION['username'], PDO::PARAM_STR);
$stmt->bindValue(2, $last_room_id + 1, PDO::PARAM_INT);
$stmt->bindValue(3, $_SESSION['butler'], PDO::PARAM_INT);
$stmt->bindValue(4, $_SESSION['breakfast'], PDO::PARAM_INT);
$stmt->bindValue(5, $_SESSION['massage'], PDO::PARAM_INT);
$stmt->bindValue(6, $_SESSION['room_type'], PDO::PARAM_STR);
$stmt->execute();
$stmt = $db->prepare("INSERT INTO booking (name, amount, room_type, room_id) VALUES (?, ?, ?, ?)");
$stmt->bindValue(1, $_SESSION['username'], PDO::PARAM_STR);
$stmt->bindValue(2, $_SESSION['totalcost'], PDO::PARAM_INT);
$stmt->bindValue(3, $_SESSION['room_type'], PDO::PARAM_STR);
$stmt->bindValue(4, $last_room_id + 1, PDO::PARAM_INT);
$stmt->execute();
echo 'booking successful!';

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
  'total_cost' => sprintf('%.2f', $_SESSION['totalcost']),
  'room_type' => $_SESSION['room_type'],
  'stars' => $hotel_info['stars'],
  'features' => ['name' =>  $features, 'cost' => sprintf('%.2f', $_SESSION['feature_cost'])],
  'additional_info' => $hotel_info['additional_info'],
];

file_put_contents('booking.json', json_encode($booking, JSON_PRETTY_PRINT));
echo json_encode($booking, JSON_PRETTY_PRINT);
