<?php
session_start(
  [
    'cookie_lifetime' => 1800,
  ]
);
include __DIR__ . '/functions.php';
$room_type = 'luxury';
$stmt = $db->prepare("SELECT discount FROM prices WHERE name = ?");
$stmt->bindValue(1, $room_type, PDO::PARAM_STR);
$stmt->execute();
$discount = $stmt->fetchColumn();

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="css/form.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
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

  <section class="input-section">

    <div class="container">
      <h2>Luxury</h2>
      <div id="myCarousel" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
          <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
          <li data-target="#myCarousel" data-slide-to="1"></li>
          <li data-target="#myCarousel" data-slide-to="2"></li>
        </ol>

        <!-- Wrapper for slides -->
        <div class="carousel-inner">
          <div class="item active">
            <img src="images/luxury-room-1.jpg" alt="" style="width:100%;">
          </div>

          <div class="item">
            <img src="images/luxury-room-2.jpg" alt="" style="width:100%;">
          </div>

          <div class="item">
            <img src="images/luxury-room-3.jpg" alt="" style="width:100%;">
          </div>
        </div>

        <!-- Left and right controls -->
        <a id='left' class="left carousel-control" href="#myCarousel" data-slide="prev">
          <span class="sr-only">Previous</span>
        </a>
        <a id='right' class="right carousel-control" href="#myCarousel" data-slide="next">
          <span class="sr-only">Next</span>
        </a>
      </div>
    </div>

    <div class="background">
      <section class="form-section">
        <h1 id="room_type">luxury</h1>
        <form action="session_variable_form.php" method="post">
          <p><?= $discount ?>% of if you book 5 days or more</p>
          <div class="form-text-section">
            <label for="username">Username
              <input class="form-text-input" name="username" type="text">
            </label>
            <label for="transferCode">Transfer code
              <input class="form-text-input" name="transferCode" type="text">
            </label>
          </div>
          <div class="date-section">
            <label for="start date">Start date
              <input name="start date" type="date" min="2023-01-01" max="2023-01-31">
            </label>
            <label for=" end date">End date
              <input name="end date" type="date" min="2023-01-01" max="2023-01-31">
            </label>
          </div>
          <div class="checkbox-section">
            <label for="butler">Butler
              <input name="butler" type="checkbox">
            </label>
            <label for="massage">Massage
              <input name="massage" type="checkbox">
            </label>
            <label for="breakfast">Breakfast
              <input name="breakfast" type="checkbox">
            </label>
          </div>
          <label for="totalcost">Totalcost
            <p id="cost"></p>
          </label>
          <?php $_SESSION['room_type'] = 'luxury'; ?>
          <input class="submit-button" id="no-cursor" type="submit">
        </form>
      </section>
      <section class="calendar">
        <?php
        include_once __DIR__ . '/calander.php';
        ?>
      </section>
    </div>

  </section>
  <?php
  include __DIR__ . '/display_cost.php';

  ?>
  <script>
    const ball = document.querySelector('.ball');
    const ball__inner = document.querySelector('.ball__inner');
    const a = document.querySelectorAll('a');

    let mouseX = 0;
    let mouseY = 0;

    let ballX = 0;
    let ballY = 0;

    let speed = 0.7;

    // Update ball position
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
    const svg = document.querySelector('svg');
    document.addEventListener("mousemove", function(event) {
      mouseX = event.pageX;
      mouseY = event.pageY;
    });

    a.forEach((a) => {
      a.addEventListener('mouseover', function(event) {
        if (event.target.matches('a')) {
          ball.style.transform = "scale(3)";
          ball.style.transition = 'transform 0.5s ease-in-out';
          ball__inner.style.display = 'block';
          ball.classList.add('ball__inner--active');

        } else {
          ball.style.transform = "scale(1)";
          ball__inner.style.display = 'none';
          ball.classList.remove('ball__inner--active');
        }
      });
    });
    a.forEach((a) => {
      a.addEventListener('mouseout', function(event) {
        if (event.target.matches('a')) {
          ball.style.transform = "scale(1)";
          ball.style.transition = 'transform 0.5s ease-in-out';
          ball__inner.style.display = 'none';
          ball.classList.remove('ball__inner--active');

        } else {
          ball.style.transform = "scale(1)";
          ball__inner.style.display = 'none';
        }
      });
    });
    document.addEventListener("mouseover", function(event) {
      if (event.target.matches('#left')) {
        ball__inner.style.transform = "rotate(0deg)";

        ball__inner.style.transition = 'transform 0.5s ease-in-out';
      } else if (event.target.matches('#right')) {
        ball__inner.style.transform = "rotate(180deg)";

      }
    });
    const input = document.querySelectorAll('input');
    input.forEach((input) => {
      input.addEventListener('mouseover', function(event) {
        if (event.target.matches('input')) {
          ball.style.transform = "scale(2.5)";
          ball.style.transition = 'transform 0.5s ease-in-out';

        }
      });
    });
    input.forEach((input) => {
      input.addEventListener('mouseout', function(event) {
        if (event.target.matches('input')) {
          ball.style.transform = "scale(1)";
          ball.style.transition = 'transform 0.5s ease-in-out';

        }
      });
    });
    const calendar = document.querySelector('table');
    calendar.addEventListener('mouseover', function(event) {
      if (event.target.matches('table')) {
        ball.style.transform = "scale(3)";
        ball.style.transition = 'transform 0.5s ease-in-out';
      }
    });
  </script>
</body>

</html>
