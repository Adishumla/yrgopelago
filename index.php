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
    <img src="images/desktop-hero.jpg" alt="">
    <div class="hero-text">
      <h1>Welcome to Serendipity Island</h1>
    </div>
  </section>
  <section class="island-info-section">
    <h2>What is Serendipity Island?</h2>
    <div class="island-info-content">
      <p>Serendipity Island is a small island in the middle of the ocean. It is a very popular tourist destination. The island is famous for the hot air ballon phenomenon that happens every day at 21:00. The hot air ballons are very beautiful and you can see them from the island.</p>
      <div class="ballon">
        <!-- <div class="clouds">
                    <img src="images/cloud1.png" alt="">
          <img src="images/cloud1.png" alt="">
        </div> -->
        <img src="images/hot-airballon.png" alt="">
        <img src="images/hot-airballon2.png" alt="">
      </div>
      <!-- cloud images that are animated -->

    </div>
  </section>
  <section class="island-todo">
    <h2>What to do on the island</h2>
    <div class="island-todo-cards">
      <div class="island-todo-card">
        <img src="images/baloon.jpg" alt="">
        <h3>Activities</h3>
        <p>There are many activities to do on the island. You can go on a boat trip, go to the spa or go to the gym.</p>
      </div>
      <div class="island-todo-card">
        <img src="images/pizza.jpg" alt="">
        <h3>Food</h3>
        <p>There are many restaurants on the island. You can eat at the restaurant or order room service.</p>
      </div>
      <div class="island-todo-card">
        <img src="images/massage.jpg" alt="">
        <h3>Massage</h3>
        <p>There is a spa on the island. You can go there to relax and get a massage.</p>
      </div>
    </div>
    <!-- <div class="backdrop">
    </div> -->
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
        <img src="images/luxury-room2.jpg" alt="">
        <h3>standard</h3>
        <p>This is the room for you if you want to live a standard life.</p>
        <p>price: 3 SEK</p>
        <a href="standard.php">
          <button>standard</button>
        </a>
      </div>
      <div class="room-card">
        <img src="images/outside-room.jpg" alt="">
        <h3>budget</h3>
        <p>This is the room for you if you want to live on a budget.</p>
        <p>price: 2 SEK</p>
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
    //paralaax effect on ballon image
    const ballon = document.querySelector('.ballon');

    window.addEventListener('scroll', function() {
      let value = window.scrollY;
      ballon.style.bottom = value * 0.5 + 'px';
    })
  </script>
</body>

</html>
