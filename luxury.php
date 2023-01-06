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
    <h1 id="room_type">luxury</h1>
    <form action="session_variable_form.php" method="post">
      <label for="username">username</label>
      <input name="username" type="text">
      <label for="transferCode">transferCode</label>
      <input name="transferCode" type="text">
      <label for="totalcost">totalcost</label>
      <p id="cost"></p>
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
      <?php $_SESSION['room_type'] = 'luxury'; ?>
      <input type="submit">
    </form>
    <script src="display_cost.js"></script>
  </section>

  <?php
  include_once 'calander.php';
  ?>
</body>

</html>
