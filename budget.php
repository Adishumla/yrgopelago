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
    <h1>budget</h1>
    <form action="postTransferCode.php" method="post">
      <label for="username">username</label>
      <input name="username" type="text">
      <label for="transferCode">transferCode</label>
      <input name="transferCode" type="text">
      <label for="totalcost">totalcost</label>
      <input name="totalcost" type="number">
      <label for="start date">start date</label>
      <input name="start date" type="date">
      <label for="end date">end date</label>
      <input name="end date" type="date">
      <label for="butler">butler</label>
      <input name="butler" type="checkbox">
      <label for="massage">massage</label>
      <input name="massage" type="checkbox">
      <label for="breakfast">breakfast</label>
      <input name="breakfast" type="checkbox">
      <?php $_SESSION['room_type'] = 'budget'; ?>
      <input type="submit">
  </section>
</body>

</html>
