<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Choose Payment</title>
  <link href="https://fonts.googleapis.com/css2?family=Luckiest+Guy&display=swap" rel="stylesheet">
  <style>
   .choose-payment-prompt {
      background-color: #f1f1f1;
      padding: 0;
      border-radius: 5px;
      text-align: center;
      margin: 20px auto;
      width: 500px; 
      height: 450px;
      font-family: 'Luckiest Guy', cursive;
      position: relative;
      aspect-ratio: 1/1;
    }

    .choose-payment-prompt h2 {
      margin: 0;
      color: #ffffff;
      font-family: 'Luckiest Guy', cursive;
      background-color: #D4471F;
      padding: 30px; 
      border-top-left-radius: 5px;
      border-top-right-radius: 5px;
      font-size: 36px; 
    }

    .choose-payment-prompt .close {
      position: absolute;
      top: 10px;
      right: 10px;
      background-color: #D4471F;
      color: #ffffff;
      border: none;
      padding: 5px 10px;
      font-family: 'Luckiest Guy', cursive;
      border-radius: 50%;
      cursor: pointer;
    }

    .choose-payment-prompt .close:hover {
      background-color: #B42B00;
    }

    .choose-payment-prompt .options {
      display: flex;
      flex-direction: column;
      align-items: center;
      margin-top: 20px;
      padding: 20px;
    }

    .choose-payment-prompt button {
      background-color: #CED3D7;
      color: #000000;
      border: none;
      padding: 15px 45px; 
      border-radius: 50px;
      font-family: 'Luckiest Guy', cursive;
      font-size: 30px;
      cursor: pointer;
      transition: background-color 0.3s ease;
      margin-bottom: 20px;
      width: 300px;
      text-transform: uppercase;
    }

    .choose-payment-prompt button:hover {
      background-color: #45a049;
    }
  </style>
</head>
<body>
  <div class="choose-payment-prompt">
    <h2>PAYMENT OPTIONS</h2>
    <span class="close">&times;</span>
    <div class="options">
      <button id="credit-card-button">CREDIT CARD</button>
      <button id="gcash-button">GCASH</button>
      <button id="cash-button">CASH MONEY</button>
    </div>
  </div>

  <script>
    // Get the choose payment prompt element
    const choosePaymentPrompt = document.querySelector('.choose-payment-prompt');

    // Get the credit card button
    const creditCardButton = document.getElementById('credit-card-button');

    // Add an event listener to the credit card button
    creditCardButton.addEventListener('click', () => {
      // Redirect to the credit card payment page
      location.href = 'card.php';
    });

    // Get the GCASH button
    const gcashButton = document.getElementById('gcash-button');

    // Add an event listener to the GCASH button
    gcashButton.addEventListener('click', () => {
      // Redirect to the GCASH payment page
      location.href = 'gcash.php';
    });

    // Get the cash button
    const cashButton = document.getElementById('cash-button');

    // Add an event listener to the cash button
    cashButton.addEventListener('click', () => {
      // Redirect to the cash payment page
      location.href = 'cash.php';
    });

    // Add an event listener to the close button
    choosePaymentPrompt.querySelector('.close').addEventListener('click', () => {
        location.href = 'cart.php';
    });
  </script>
</body>
</html>