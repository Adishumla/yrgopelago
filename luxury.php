<?php
session_start(
  [
    'cookie_lifetime' => 360,
  ]
);

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
  <!-- <section class="img-section">
  <div class="img-text">
    <img src="images/standard-room.jpg" alt="">
    <h1>Living in luxury</h1>
  </div>

  </section> -->

  <section class="input-section">

    <div class="container">
      <!-- <h2>Luxury</h2> -->
      <div id="myCarousel" class="carousel slide" data-ride="carousel">
        <!-- Indicators -->
        <ol class="carousel-indicators">
          <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
          <li data-target="#myCarousel" data-slide-to="1"></li>
          <li data-target="#myCarousel" data-slide-to="2"></li>
        </ol>

        <!-- Wrapper for slides -->
        <div class="carousel-inner">
          <div class="item active">
            <img src="images/luxury-room2.jpg" alt="Los Angeles" style="width:100%;">
          </div>

          <div class="item">
            <img src="images/lake-town-hero.jpg" alt="Chicago" style="width:100%;">
          </div>

          <div class="item">
            <img src="images/outside-room.jpg" alt="New york" style="width:100%;">
          </div>
        </div>

        <!-- Left and right controls -->
        <a class="left carousel-control" href="#myCarousel" data-slide="prev">
          <span class="glyphicon glyphicon-chevron-left"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#myCarousel" data-slide="next">
          <span class="glyphicon glyphicon-chevron-right"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>
    </div>

    <div class="background">
      <section class="form-section">
        <h1 id="room_type">luxury</h1>
        <form action="session_variable_form.php" method="post">
          <div class="form-text-section">
            <label for="username">username
              <input class="form-text-input" name="username" type="text">
            </label>
            <label for="transferCode">transferCode
              <input class="form-text-input" name="transferCode" type="text">
            </label>
          </div>
          <div class="date-section">
            <label for="start date">start date
              <input name="start date" type="date" min="2023-01-01" max="2023-01-31">
            </label>
            <label for=" end date">end date
              <input name="end date" type="date" min="2023-01-01" max="2023-01-31">
            </label>
          </div>
          <div class="checkbox-section">
            <label for="butler">butler
              <input name="butler" type="checkbox">
            </label>
            <label for="massage">massage
              <input name="massage" type="checkbox">
            </label>
            <label for="breakfast">breakfast
              <input name="breakfast" type="checkbox">
            </label>
          </div>
          <label for="totalcost">totalcost
            <p id="cost"></p>
          </label>
          <?php $_SESSION['room_type'] = 'luxury'; ?>
          <input class="submit-button" type="submit">
        </form>
        <!-- <script src="display_cost.js"></script> -->
      </section>
      <section class="calendar">
        <?php
        include_once __DIR__ . '/calander.php';
        ?>
      </section>
    </div>

  </section>
  <?php
  include 'display_cost.php';

  ?>
  <script>
  </script>
</body>

</html>
