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
  <link rel="stylesheet" href="css/index.css">
  <title>form</title>
</head>
<!-- <style>
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
</style> -->

<body>
  <section class="hero">
    <img src="images/baloon.jpg" alt="">
    <div class="hero-text">
      <h1>Welcome to Serendipity Island</h1>
    </div>
  </section>
  <section class="room-select-section">
    <h2>Our rooms</h2>
    <div class="room-select">
      <div class="room-card">
        <img src="images/standard-room.jpg" alt="">
        <h3>luxury</h3>
        <p>This is the room for you if you want to live in luxury.</p>
        <p>price: 5 SEK</p>
        <a href="luxury.php">
          <button>luxury</button>
        </a>
      </div>
      <div class="room-card">
        <img src="images/standard-room.jpg" alt="">
        <h3>luxury</h3>
        <p>This is the room for you if you want to live in luxury.</p>
        <p>price: 5 SEK</p>
        <a href="standard.php">
          <button>standard</button>
        </a>
      </div>
      <div class="room-card">
        <img src="images/standard-room.jpg" alt="">
        <h3>luxury</h3>
        <p>This is the room for you if you want to live in luxury.</p>
        <p>price: 5 SEK</p>
        <a href="budget.php">
          <button>budget</button>
        </a>
      </div>
    </div>
  </section>
  <form action="admin.php" method="post">
    <label for="api_key">api_key</label>
    <input name="api_key" type="text">
    <input type="submit">
  </form>
  <script>
  </script>
</body>

</html>
