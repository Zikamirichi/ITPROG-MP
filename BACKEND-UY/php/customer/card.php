<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Luckiest+Guy&display=swap" rel="stylesheet">
    <title>Credit Card</title>
	<style>
		.credit-card-prompt {
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

		.credit-card-prompt h2 {
		  margin-top: 0;
		  color: #ffffff;
		  background-color: #D4471F;
		  padding: 10px;
		  border-radius: 5px;
		}

		.credit-card-prompt .close {
		  position: absolute;
		  top: -45px;
		  right: 10px;
		  background-color: #f1f1f1;
		  color: #333;
		  border: none;
		  padding: 5px 10px;
		  font-family: 'Luckiest Guy', cursive;
		  border-radius: 50%;
		  cursor: pointer;
		}

		.credit-card-prompt .close:hover {
		  background-color: #ddd;
		}

		.card-details {
		  display: flex;
		  flex-direction: column;
		  align-items: center;
		  margin-top: 50px;
		}

		.card-details p {
		  font-size: 18px;
		  margin-bottom: 20px;
		}

		.card-details img {
		  width: 50px;
		  height: 50px;
		}

		.credit-card-prompt a {
		  margin-top: 50px;
		  background-color: #CED3D7;
		  color: rgb(0, 0, 0);
		  border: none;
		  padding: 10px;
		  border-radius: 5px;
		  cursor: pointer;
		  transition: background-color 0.3s ease;
          text-decoration: none;
		}

		.credit-card-prompt a:hover {
		  background-color: #45a049;
		}
	</style>
</head>
<body>
    <div id="credit-card-prompt" class="credit-card-prompt">
        <a href="cart.php" class="close">&times;</a>
		<h2>Credit Card</h2>
        
		<div class="card-details">
			<p>Tap Your Credit Card Here to Pay</p>
			<img src="../../images/tap_icon.png" alt="Tap Icon"> 
		</div>
        <?php
            session_start();
            $totalBill = $_SESSION['totalBill'];
            
            echo "<h3>Total Bill: Php $totalBill</h3>";
        ?>
        <a href="paid.php">Done</a>
	</div>
</body>
</html>