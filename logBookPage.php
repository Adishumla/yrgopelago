<?php

declare(strict_types=1);
$db = new PDO('sqlite:' . __DIR__ . '/database/identifier.sqlite');
//These three lines adds all the values of 0-1 in each row in the tables and returns the total amount
$butlerFeature = array_sum($db->query("SELECT butler FROM feature")->fetchAll(PDO::FETCH_COLUMN));
$breakfastFeature = array_sum($db->query("SELECT breakfast FROM feature")->fetchAll(PDO::FETCH_COLUMN));
$massageFeature = array_sum($db->query("SELECT massage FROM feature")->fetchAll(PDO::FETCH_COLUMN));

//This line is kinda unnecessary but it returns the highest value out of all the variables.
$mostUsedFeature = max($butlerFeature, $breakfastFeature, $massageFeature);

//I wanted to do the following two lines in one line but had a problem where i only got one of the values instead of the two, therefore i did two separate lines
$vipAmount = implode($db->query("SELECT amount FROM booking ORDER BY amount DESC LIMIT 1")->fetchAll(PDO::FETCH_COLUMN));
$vipName = implode($db->query("SELECT name FROM booking ORDER BY amount DESC LIMIT 1")->fetchAll(PDO::FETCH_COLUMN));
$totalRevenue = $db->query("SELECT amount FROM booking")->fetchAll(PDO::FETCH_COLUMN);
//The count basically counts how many bookings there were
$totalBookings = count($totalRevenue);
//THe array_sum adds all the sums together to a total
$totalRevenue = array_sum($totalRevenue);
//the number format here is to make it not have so many decimals
$revenuePerBooking = number_format($totalRevenue / $totalBookings, 2, ',', '');


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="css/index.css">
  <title>logbookPage</title>
  <style>
    /* i used mostly styling from the index.css but added some new lines for this page here instead of the index.css because i thought it would be easier to read. */
    p {
      font-size: 18px;
      font-weight: 400;
      margin-bottom: 20px;
      width: 400px;
      text-align: left;
      letter-spacing: 1px;
      line-height: 1.5;
      padding: 0 20px;
      color: white;
    }

    .gridSection {
      display: flex;
      flex-direction: row;
      justify-content: space-around;
      flex-wrap: wrap;
      background-color: #a0c6cb;
      gap: 1rem;
      padding-top: 1rem;

    }

    .logbookButton {
      opacity: 0;
      width: 200px;
      height: 50px;
      border: none;
      background: #fff;
      color: #000;
      border: 1px solid #000;
      border-radius: 0px;
      margin: 10px;
      cursor: none;
      transition: 0.5s;
      outline: none;
      font-family: inherit;
      font-size: inherit;
      line-height: inherit;
      cursor: pointer;
      animation: showWord 1s 1s forwards;
    }


    .logbookCard,
    .factBox {
      padding: 10px;
      width: auto;
      height: auto;
      background-color: #0191a4;
      border-radius: 5px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }
  </style>
</head>

<body>
  <!-- i removed the cool cursor because it was alot of js code that i felt was unnecessary to paste into this page -->
  <section class="hero">
    <img src="images/baloon.jpg" alt="">
    <div class="hero-text">
      <div class="word1">Welcome to</div>
      <div class="word2">The Logbook
      </div>
      <button class="logbookButton">View</button>
  </section>

  <!-- This section is where all the cards are put into after they are created -->
  <section class="gridSection"></section>

  <script>
    //This boolean is used so you cant spam the button and it will generate the same cards again and again
    let buttonClicked = false;
    const logbookButton = document.querySelector(".logbookButton");
    const gridSection = document.querySelector(".gridSection");
    let totalCost = 0;

    logbookButton.addEventListener("click", function() {
      if (!buttonClicked) {
        buttonClicked = true;

        //create the factbox and place it inside the gridSection
        let factbox = document.createElement("div");
        factbox.setAttribute("class", "factBox");
        factbox.innerHTML = `
      <p>Hotel Serendipity factbox:</p>
      <p>Total bookings: <?php echo $totalBookings ?></p>
      <p>Total revenue: <?php echo $totalRevenue ?>$</p>
      <p>Average revenue per booking: <?php echo $revenuePerBooking ?>$</p>
      <p>Your most frequent bought feature was the Butler with a wopping figure of: <?php echo $mostUsedFeature ?></p>
      <p>Your biggest spender was <?php echo $vipName . " with an amount of " . $vipAmount ?>$ in one booking</p>
    `;
        document.querySelector(".gridSection").appendChild(factbox);

        //The following code creates all the loogbook cards and puts them inside the gridSection. I created a new json file called alteredLogbook because the syntax was not coherent amount all the bookings in the logbook.json which created some issues and instead of manipulating it i made a new one.
        fetch('alteredLogbook.json')
          .then(response => response.json())
          .then(json => {
            for (let key in json) {
              let obj = json[key];
              let div = document.createElement("div");
              div.setAttribute("class", "logbookCard");
              div.innerHTML = `
            <p>Island: ${obj.island}</p>
            <p>Hotel: ${obj.hotel}</p>
            <p>Arrival date: ${obj.arrival_date}</p>
            <p>Departure date: ${obj.departure_date}</p>
            <p>Total cost: ${obj.total_cost}$</p>
            <p>Stars: ${obj.stars}</p>
            `;
              totalCost = totalCost + parseFloat(obj.total_cost);
              if (obj.features) {
                obj.features.forEach(feature => {
                  div.innerHTML += `<p>Features: ${feature.name} = ${feature.cost}$</p>`;
                  totalCost = totalCost + parseFloat(feature.cost);
                });
              }

              if (obj.additional_info) {
                div.innerHTML += `<p>Additional Info: ${obj.additional_info}</p>`;
              }
              document.body.appendChild(div);
              document.querySelector(".gridSection").appendChild(div);
            }
            let factBoxLogbook = document.createElement("div");
            factBoxLogbook.setAttribute("class", "logbookCard");
            factBoxLogbook.innerHTML = `<p> Total Cost:</p>
            <p> The total cost of all your bookings visiting other hotels were: ${totalCost}$</p>`;
            document.querySelector(".gridSection").appendChild(factBoxLogbook);
            gridSection.scrollIntoView({
              behavior: "smooth",
              block: "start"
            });
          })
          .catch(error => console.error(error));
      }
    });
  </script>

</body>