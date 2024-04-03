<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://fonts.googleapis.com/css2?family=Luckiest+Guy&display=swap" rel="stylesheet">
  <style>
   .choose-payment-prompt {
        background-color: #f1f1f1;
        padding: 20px;
        border-radius: 5px;
        text-align: center;
        margin: 20px auto;
        width: 400px;
        height: 400px;
        font-family: 'Luckiest Guy', cursive;
        position: relative;
        aspect-ratio: 1/1;
    }

    .choose-payment-prompt h2 {
      margin-top: 0;
      color: #ffffff;
      font-family: 'Luckiest Guy', cursive;
      background-color: #D4471F;
      padding: 10px;
      border-radius: 5px;
    }

    .choose-payment-prompt .close {
      position: absolute;
      top: 10px;
      right: 10px;
      background-color: #f1f1f1;
      color: #333;
      border: none;
      padding: 5px 10px;
      font-family: 'Luckiest Guy', cursive;
      border-radius: 50%;
      cursor: pointer;
    }

    .choose-payment-prompt .close:hover {
      background-color: #ddd;
    }

    .choose-payment-prompt .options {
      display: flex;
      flex-direction: column;
      align-items: center;
      margin-top: 20px;
    }

    .choose-payment-prompt a {
      margin-bottom: 10px;
      background-color: #CED3D7;
      color: rgb(0, 0, 0);
      border: none;
      padding: 15px 45px; /* 30% longer padding */
      border-radius: 50px;
      font-family: 'Luckiest Guy', cursive;
      font-size: 25px;
      cursor: pointer;
      transition: background-color 0.3s ease;
      text-decoration: none;
    }

    .choose-payment-prompt a:hover {
      background-color: #45a049;
    }
  </style>
</head>
    <body>
        <div class="choose-payment-prompt">
            <a href="cart.php" class="close">&times;</a>
            <h2>PAYMENT OPTIONS</h2>
            <div class="options">
                <a href="gcash.php">GCash</a><br>
                <a href="card.php">Credit Card</a><br>
                <a href="cash.php">Cash</a><br>
            </div>
        </div>
    </body>
</html>