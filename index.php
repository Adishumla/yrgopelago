<?php
session_start(
  [
    'cookie_lifetime' => 1800,
  ]
);
include_once __DIR__ . '/functions.php'; // always use __DIR__ when including files in PHP to avoid problems with relative paths
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
      <div class="word1">Welcome to</div>
      <div class="word2">Serendipity Island</div>
    </div>
  </section>
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
  <section class="info-container">
    <span class="">
      <h2 class="first-word">Serendipity</h2>
      <h2 class="second-word">Island</h2>
    </span>
    <p class="third-word"> Serendipity Island is a small island in the middle of the ocean. It is a very popular tourist destination. The island is famous for the hot air ballon phenomenon that happens every day at 21:00. The hot air ballons are very beautiful and you can see them from all our rooms.</p>
  </section>
  <section class="room-select-section">
    <h2>Our rooms</h2>
    <div class="room-select">
      <div class="room-card">
        <img src="images/luxury-room-1.jpg" alt="">
        <h3>luxury</h3>
        <p>This is the room for you if you want to live a luxury life. This room has a sauna and a jacuzzi with a view of the ocean.</p>
        <p>price: <?= $luxury_price = $db->query("SELECT price FROM prices WHERE name = 'luxury'")->fetchAll(PDO::FETCH_ASSOC)[0]['price'] ?> SEK</p>
        <a href="luxury.php">
          <button>luxury</button>
        </a>
      </div>
      <div class="room-card">
        <img src="images/standard-room-1.jpg" alt="">
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
        <p>This is the room for you if you want to live the budget life. This room has a view of the ocean because it is outside.</p>
        <p>price: <?= $budget_price = $db->query("SELECT price FROM prices WHERE name = 'budget'")->fetchAll(PDO::FETCH_ASSOC)[0]['price'] ?> SEK</p>
        <a href="budget.php">
          <button>budget</button>
        </a>
      </div>
    </div>
  </section>
  <footer>
    <form action="admin.php" method="post">
      <label for="api_key">api_key</label>
      <input name="api_key" type="text">
      <input type="submit">
    </form>
  </footer>
  <script>
    const ballon = document.querySelectorAll('.ballon img');
    const track = document.getElementById("image-track");

    // save the x-coordinate of the mouse down event in the track's data attribute
    const handleOnDown = e => track.dataset.mouseDownAt = e.clientX;

    // Reset the data attribute when mouse is released
    const handleOnUp = () => {
      track.dataset.mouseDownAt = "0";
      track.dataset.prevPercentage = track.dataset.percentage;
    }

    // Move the track on mouse move event if the mouse is down
    const handleOnMove = e => {
      if (track.dataset.mouseDownAt === "0") return;

      // Calculate the mouse delta, the difference in x-coordinate from mouse down to move event (delta means the change in value)
      const mouseDelta = parseFloat(track.dataset.mouseDownAt) - e.clientX,
        maxDelta = window.innerWidth / 2; // The max delta is half the window width

      // Calculate the percentage of movement, based on the mouse delta and the max delta (percentage means the ratio of a number to another number)
      const percentage = (mouseDelta / maxDelta) * -100,
        nextPercentageUnconstrained = parseFloat(track.dataset.prevPercentage) + percentage,
        nextPercentage = Math.max(Math.min(nextPercentageUnconstrained, 0), -65); // Constrain the percentage to be between 0 and -65
      // (-65 so that the last image is not cut off and the user can't drag the track further to the left)

      track.dataset.percentage = nextPercentage;

      // Animate the movement of the track
      track.animate({ // animate the transform property of the track (FOR TRACK)
        transform: `translate(${nextPercentage}%, -50%)` // translate the track by the percentage calculated above
      }, {
        duration: 1500, // duration of the animation
        fill: "forwards" // keep the animation state after it finishes (so that the track stays in the new position)
      });

      // Animate the movement of all images within the track (FOR IMAGES)
      for (const image of track.getElementsByClassName("image")) {
        image.animate({ // animate the objectPosition property of the image
          objectPosition: `${100 + nextPercentage}% center` // move the image by the percentage calculated above
        }, {
          duration: 1200, // duration of the animation (shorter than the track animation so that the images move faster than the track, creating the parallax effect)
          fill: "forwards" // keep the animation state after it finishes (so that the image stays in the new position)
        });
      }
    }

    // Add event listeners for mouse and touch events (touch events are for mobile devices)
    window.onmousedown = e => handleOnDown(e);
    window.ontouchstart = e => handleOnDown(e.touches[0]);
    window.onmouseup = e => handleOnUp(e);
    window.ontouchend = e => handleOnUp(e.touches[0]);
    window.onmousemove = e => handleOnMove(e);
    window.ontouchmove = e => handleOnMove(e.touches[0]);


    const ball = document.querySelector('.ball');
    // set the initial position of the ball and the mouse
    let mouseX = 0;
    let mouseY = 0;

    let ballX = 0;
    let ballY = 0;
    // set the speed of the ball movement (the higher the number, the faster the ball will move)
    let speed = 1;

    //get mouse position on mouse move
    function mousePosition(e) {
      mouseX = e.clientX;
      mouseY = e.clientY;
    }

    //get ball position on ball move
    function ballPosition() {
      ballX = ball.offsetLeft;
      ballY = ball.offsetTop;
    }

    // move the ball
    function animate() {
      let distX = mouseX - (ballX + ball.offsetWidth / 2); // get the distance between the mouse and the ball on the x-axis
      let distY = mouseY - (ballY + ball.offsetHeight / 2); // get the distance between the mouse and the ball on the y-axis
      let dampening = 0.1; // dampening smooths the movement of the ball
      ballX += distX * (speed * dampening); // move the ball on the x-axis
      ballY += distY * (speed * dampening); // move the ball on the y-axis
      if (Math.abs(distX) < 1 && Math.abs(distY) < 1) { // if the ball is close to the mouse, set the ball position to the mouse position
        ballX = mouseX - ball.offsetWidth / 2; //x-axis position of the ball
        ballY = mouseY - ball.offsetHeight / 2; //y-axis position of the ball
      }

      ball.style.left = ballX + "px"; // set the ball position on the x-axis
      ball.style.top = ballY + "px"; // set the ball position on the y-axis

      requestAnimationFrame(animate); // call the animate function again when the browser is ready to draw the next frame
    }

    animate();

    document.addEventListener("mousemove", function(event) {
      mouseX = event.pageX;
      mouseY = event.pageY;
    });

    const buttons = document.querySelectorAll('button');
    buttons.forEach(button => { // loop through all buttons and add event listeners to them that will change the ball size on hover
      button.addEventListener('mouseover', () => {
        ball.style.transform = 'scale(3)'
        ball.style.transition = 'transform 0.5s ease-in-out';
        ball.style.transformOrigin = 'center';
      });
      button.addEventListener('mouseout', () => { // change the ball size back to normal when the mouse leaves the button
        ball.style.transform = 'scale(1)'
      });
    });

    const images = document.querySelectorAll('.image');
    const ball__inner = document.querySelector('.ball__inner');
    track.addEventListener('mouseover', () => { // change the ball size and display the inner ball when the mouse enters the track
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

    const infoContainer = document.querySelector('.info-container');
    const firstWord = document.querySelector('.first-word');
    const secondWord = document.querySelector('.second-word');
    const thirdWord = document.querySelector('.third-word');

    function changeColor() {
      if (window.scrollY > infoContainer.offsetTop - 100) { // change the color of the text and background when the user scrolls down to the info container
        infoContainer.style.backgroundColor = 'black';
        infoContainer.style.color = 'white';
        firstWord.classList.add('first-animation');
        secondWord.classList.add('second-animation');
        thirdWord.classList.add('third-animation');
      } else {
        document.body.style.backgroundColor = 'white';
        document.body.style.color = 'black';
      }
    }
    window.addEventListener('scroll', changeColor);

    const roomSection = document.querySelector('.room-select-section');

    function changeColorBack() { // change the color of the text and background when the user scrolls down to the room section
      if (window.scrollY > roomSection.offsetTop - 100) {
        infoContainer.style.backgroundColor = 'white';
        infoContainer.style.color = 'black';
      }
    }
    window.addEventListener('scroll', changeColorBack);
  </script>
</body>

</html>
