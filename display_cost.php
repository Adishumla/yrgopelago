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
      price: <?= $prices[0]['price'] ?>,
      discount: <?= $prices[0]['discount'] ?>
    },
    {
      type: 'standard',
      price: <?= $prices[1]['price'] ?>,
      discount: <?= $prices[1]['discount'] ?>
    },
    {
      type: 'budget',
      price: <?= $prices[2]['price'] ?>,
      discount: <?= $prices[2]['discount'] ?>
    },
  ];
  // find the price of the selected room type
  const findPrice = (room_type) => {
    const room = room_types.find((room) => room.type === room_type);
    return room.price;
  };
  const findDiscount = (room_type) => {
    const room = room_types.find((room) => room.type === room_type);
    return (-room.discount + 100) / 100;
  };
  cost.innerHTML = '$' + 0;
  const inputs = document.querySelectorAll('input');
  inputs.forEach((input) => {
    input.addEventListener('change', () => {
      const startdate = new Date(start.value);
      const enddate = new Date(end.value);
      const days = (enddate - startdate) / (1000 * 60 * 60 * 24) + 1;
      let totalcost = days * findPrice(room_type);
      let discount = findDiscount(room_type);
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
        totalcost = totalcost * discount;
      }
      cost.innerText = totalcost;
      if (days < 1 || startdate > enddate || isNaN(days) || isNaN(totalcost) || totalcost < 0) {
        cost.innerText = 0;
      }
      // add $ to totalcost
      cost.innerText = '$' + cost.innerText;
    });
  });
</script>
