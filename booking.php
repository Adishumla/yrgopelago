<?php

use function PHPSTORM_META\type;

session_start(
  [
    'cookie_lifetime' => 240,
  ]
);


//get data from database
$db = new PDO('sqlite:database/identifier.sqlite');
// get last id from database table $_SESSION['room_type']
$last_feature_id = $db->query("SELECT id FROM $_SESSION[room_type] ORDER BY id DESC LIMIT 1")->fetchColumn();
$last_room_id = $db->query("SELECT id FROM $_SESSION[room_type] ORDER BY id DESC LIMIT 1")->fetchColumn();
/* echo $last_room_id = $last_room_id + 1;
echo gettype($last_room_id);
echo '<br>';
echo $last_feature_id = (int) $last_feature_id + 1;
echo gettype($last_feature_id); */
//insert data into database
$db->query("INSERT INTO $_SESSION[room_type] (name, start_date, end_date, feature_id) VALUES ('$_SESSION[username]', '$_SESSION[start_date]', '$_SESSION[end_date]', $last_feature_id + 1)");
$db->query("INSERT INTO feature (name, room_id, butler, breakfast, massage, room_type) VALUES ('$_SESSION[username]', $last_room_id + 1, '$_SESSION[butler]', '$_SESSION[breakfast]', '$_SESSION[massage]', '$_SESSION[room_type]')");
$db->query("INSERT INTO booking (name, amount, room_type, room_id) VALUES ('$_SESSION[username]', '$_SESSION[totalcost]', '$_SESSION[room_type]', $last_room_id + 1)");
echo 'booking successful';


/* header('Location: index.php'); */
