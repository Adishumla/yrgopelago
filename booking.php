<?php
session_start(
  [
    'cookie_lifetime' => 240,
  ]
);


//get data from database
$db = new PDO('sqlite:database/identifier.sqlite');

//insert data into database
$db->exec("INSERT INTO booking (name, start_date, end_date, amount) VALUES ('$_SESSION[username]', '$_SESSION[start_date]', '$_SESSION[end_date]', '$_SESSION[totalcost]')");

/* header('Location: index.php'); */
