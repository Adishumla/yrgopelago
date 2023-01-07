<?php
$db = new PDO('sqlite:' . __DIR__ . '/database/identifier.sqlite');
// get prices for each room type
$prices = $db->query("SELECT * FROM prices")->fetchAll(PDO::FETCH_ASSOC);
?>
<script>
  const cost = document.getElementById('cost');
  const butler = document.querySelector('input[name="butler"]');
  const massage = document.querySelector('input[name="massage"]');
  const breakfast = document.querySelector('input[name="breakfast"]');
  const start = document.querySelector('input[name="start date"]');
  const end = document.querySelector('input[name="end date"]');
  const room_type = document.querySelector('#room_type').innerHTML;

  const room_types = [{
      type: 'luxury',
      price: <?= $prices[0]['price'] ?>
    },
    {
      type: 'standard',
      price: <?= $prices[1]['price'] ?>
    },
    {
      type: 'budget',
      price: <?= $prices[2]['price'] ?>
    },
  ];

  // find the price of the selected room type
  const findPrice = (room_type) => {
    const room = room_types.find((room) => room.type === room_type);
    return room.price;
  };
  // 1 event listener for all inputs and update the cost accordingly. cost per day is 2 and 2 for each extra service selected, if the user selects more than 5 days the cost is reduced by 10% to the total cost
  const inputs = document.querySelectorAll('input');
  inputs.forEach((input) => {
    input.addEventListener('change', () => {
      const startdate = new Date(start.value);
      const enddate = new Date(end.value);
      const days = (enddate - startdate) / (1000 * 60 * 60 * 24) + 1;
      let totalcost = days * findPrice(room_type);
      if (butler.checked) {
        totalcost += 2;
      }
      if (massage.checked) {
        totalcost += 2;
      }
      if (breakfast.checked) {
        totalcost += 2;
      }
      if (days >= 5) {
        totalcost = totalcost * 0.9;
      }
      cost.innerText = totalcost;
      if (days < 1 || startdate > enddate || isNaN(days) || isNaN(totalcost)) {
        cost.innerText = 0;
      }
    });
  });
</script>
