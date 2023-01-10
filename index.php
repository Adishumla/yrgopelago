<?php
session_start(
  [
    'cookie_lifetime' => 120,
  ]
);
include_once __DIR__ . '/functions.php';
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

<body>
  <div class="ball">
    <div class="ball__inner">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
        <path d="M41.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l192 192c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.3 256 278.6 86.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-192 192z" />
      </svg>
    </div>
  </div>
  <section class="hero">
    <img src="images/baloon.jpg" alt="">
    <div class="hero-text">
      <h1>Welcome to Serendipity Island</h1>
    </div>
  </section>
  <!--   <section class="island-info-section">
    <h2>What is Serendipity Island?</h2>
    <div class="island-info-content">
      <p>Serendipity Island is a small island in the middle of the ocean. It is a very popular tourist destination. The island is famous for the hot air ballon phenomenon that happens every day at 21:00. The hot air ballons are very beautiful and you can see them from the island.</p>
      <div class="ballon">
        <img src="images/hot-airballon.png" alt="">
        <img src="images/hot-airballon2.png" alt="">
      </div>
    </div>
  </section> -->
  <!-- <section class="island-todo">
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
  </section> -->
  <section class="parallax-container">
    <h2>The beauty of Serendipity Island</h2>
    <section class="img-container">
      <div id="image-track" data-mouse-down-at="0" data-prev-percentage="0">
        <img class="image" src="images/baloon.jpg" draggable="false" />
        <img class="image" src="images/pool-hero.jpg" draggable="false" />
        <img class="image" src="images/cocktail.jpg" draggable="false" />
        <img class="image" src="images/under-water.jpg" draggable="false" />
        <img class="image" src="images/desktop-hero.jpg" draggable="false" />
        <img class="image" src="images/maldives.jpg" draggable="false" />
        <img class="image" src="images/maldives2.jpg" draggable="false" />
        <img class="image" src="images/lake-town-hero.jpg" draggable="false" />
      </div>
    </section>
  </section>
  <section class="room-select-section">
    <h2>Our rooms</h2>
    <div class="room-select">
      <div class="room-card">
        <img src="images/standard-room.jpg" alt="">
        <h3>luxury</h3>
        <p>This is the room for you if you want to live a luxury life. This room has a sauna and a jacuzzi with a view of the ocean.</p>
        <p>price: <?= $luxury_price = $db->query("SELECT price FROM prices WHERE name = 'luxury'")->fetchAll(PDO::FETCH_ASSOC)[0]['price'] ?> SEK</p>
        <a href="luxury.php">
          <button>luxury</button>
        </a>
      </div>
      <div class="room-card">
        <img src="images/luxury-room2.jpg" alt="">
        <h3>standard</h3>
        <p>This is the room for you if you want to live a standard life. This room has a view of the ocean from its large balcony.</p>
        <p>price: <?= $standard_price = $db->query("SELECT price FROM prices WHERE name = 'standard'")->fetchAll(PDO::FETCH_ASSOC)[0]['price'] ?> SEK</p>
        <a href="standard.php">
          <button>standard</button>
        </a>
      </div>
      <div class="room-card">
        <img src="images/outside-room.jpg" alt="">
        <h3>budget</h3>
        <p>This is the room for you if you want to live on a budget life. This room has a view of the ocean because it is outside.</p>
        <p>price: <?= $budget_price = $db->query("SELECT price FROM prices WHERE name = 'budget'")->fetchAll(PDO::FETCH_ASSOC)[0]['price'] ?> SEK</p>
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
    const ballon = document.querySelectorAll('.ballon img');
    const track = document.getElementById("image-track");

    const handleOnDown = e => track.dataset.mouseDownAt = e.clientX;

    const handleOnUp = () => {
      track.dataset.mouseDownAt = "0";
      track.dataset.prevPercentage = track.dataset.percentage;
    }

    const handleOnMove = e => {
      if (track.dataset.mouseDownAt === "0") return;

      const mouseDelta = parseFloat(track.dataset.mouseDownAt) - e.clientX,
        maxDelta = window.innerWidth / 2;

      const percentage = (mouseDelta / maxDelta) * -100,
        nextPercentageUnconstrained = parseFloat(track.dataset.prevPercentage) + percentage,
        nextPercentage = Math.max(Math.min(nextPercentageUnconstrained, 0), -100);

      track.dataset.percentage = nextPercentage;

      track.animate({
        transform: `translate(${nextPercentage}%, -50%)`
      }, {
        duration: 1200,
        fill: "forwards"
      });

      for (const image of track.getElementsByClassName("image")) {
        image.animate({
          objectPosition: `${100 + nextPercentage}% center`
        }, {
          duration: 1200,
          fill: "forwards"
        });
      }
    }

    /* -- Had to add extra lines for touch events -- */

    window.onmousedown = e => handleOnDown(e);

    window.ontouchstart = e => handleOnDown(e.touches[0]);

    window.onmouseup = e => handleOnUp(e);

    window.ontouchend = e => handleOnUp(e.touches[0]);

    window.onmousemove = e => handleOnMove(e);

    window.ontouchmove = e => handleOnMove(e.touches[0]);

    const ball = document.querySelector('.ball');

    let mouseX = 0;
    let mouseY = 0;

    let ballX = 0;
    let ballY = 0;

    let speed = 0.5;

    //get mouse position
    function mousePosition(e) {
      mouseX = e.pageX;
      mouseY = e.pageY;
    }

    //get ball position
    function ballPosition() {
      ballX = ball.offsetLeft;
      ballY = ball.offsetTop;
    }

    function animate() {
      let distX = mouseX - (ballX + ball.offsetWidth / 2);
      let distY = mouseY - (ballY + ball.offsetHeight / 2);
      let dampening = 0.1;
      ballX += distX * (speed * dampening);
      ballY += distY * (speed * dampening);
      if (Math.abs(distX) < 1 && Math.abs(distY) < 1) {
        ballX = mouseX - ball.offsetWidth / 2;
        ballY = mouseY - ball.offsetHeight / 2;
      }

      ball.style.left = ballX + "px";
      ball.style.top = ballY + "px";

      requestAnimationFrame(animate);
    }

    animate();

    document.addEventListener("mousemove", function(event) {
      mouseX = event.pageX;
      mouseY = event.pageY;
    });

    const buttons = document.querySelectorAll('button');
    buttons.forEach(button => {
      button.addEventListener('mouseover', () => {
        ball.style.transform = 'scale(3)'
        ball.style.transition = 'transform 0.5s ease-in-out';
        ball.style.transformOrigin = 'center';
      });
      button.addEventListener('mouseout', () => {
        ball.style.transform = 'scale(1)'
      });
    });

    const images = document.querySelectorAll('.image');
    const ball__inner = document.querySelector('.ball__inner');
    track.addEventListener('mouseover', () => {
      ball.style.transform = 'scale(3)'
      ball.style.transition = 'transform 0.5s ease-in-out';
      ball.style.transformOrigin = 'center';
      ball__inner.style.display = 'block';
      ball__inner.style.mixBlendMode = 'normal';
      ball.classList.add('ball__inner--active');
    });
    track.addEventListener('mouseout', () => {
      ball.style.transform = 'scale(1)'
      ball__inner.style.display = 'none';
      ball.classList.remove('ball__inner--active');
    });
  </script>
</body>

</html>
