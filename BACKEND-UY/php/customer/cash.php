<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cash</title>
    <link href="https://fonts.googleapis.com/css2?family=Luckiest+Guy&display=swap" rel="stylesheet">
	<style>
		.cash-prompt {
		  background-color: #f1f1f1;
		  padding: 20px;
		  border-radius: 5px;
		  text-align: center;
		  margin: 10px auto; /* reduced top and bottom margins */
		  width: 400px;
		  height: 400px;
		  font-family: 'Luckiest Guy', cursive;
		  position: relative;
		  aspect-ratio: 1/1;
		}

		.cash-prompt h2 {
		  margin-top: 0;
		  color: #ffffff;
		  background-color: #D4471F;
		  padding: 10px;
		  border-radius: 5px;
		}

		.cash-prompt .close {
		  position: absolute;
		  top: -30px;
		  right: 10px;
		  background-color: #f1f1f1;
		  color: #333;
		  border: none;
		  padding: 5px 10px;
		  font-family: 'Luckiest Guy', cursive;
		  border-radius: 50%;
		  cursor: pointer;
		}

		.cash-prompt .close:hover {
		  background-color: #ddd;
		}

		.cash-details {
		  display: flex;
		  flex-direction: column;
		  align-items: center;
		  margin-top: 30px; 
		}

		.cash-details p {
		  font-size: 18px;
		  margin-bottom: 20px;
		}

		.cash-details #total-payment {
		  font-size: 24px;
		  font-weight: bold;
		  margin-bottom: 10px;
		}

		.cash-details #change {
		  font-size: 24px;
		  font-weight: bold;
		  color: green;
		}

		.cash-prompt a {
		  margin-top: 30px; 
		  background-color: #CED3D7;
		  color: rgb(0, 0, 0);
		  border: none;
		  padding: 10px;
		  border-radius: 5px;
		  cursor: pointer;
		  transition: background-color 0.3s ease;
          text-decoration: none;
		}

		.cash-prompt a:hover {
		  background-color: #45a049;
		}
	</style>
</head>
<body>
    <div id="cash-prompt" class="cash-prompt">
        <a href="cart.php" class="close">&times;</a>
        <h2>CASH</h2>
        <div class="cash-details">
            <p>TOTAL PAYMENT</p>
        </div>
        <?php
        session_start();
        $totalBill = $_SESSION['totalBill'];

        $currentAmount = isset($_SESSION['currentAmount']) ? $_SESSION['currentAmount'] : 0; // Current amount received
        $change = isset($_SESSION['change']) ? $_SESSION['change'] : 0; // Change to be dispensed
        
        echo "<h3>Total Bill: Php $totalBill</h3>";
        
        // Check if form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Get the input value
            $inputAmount = isset($_POST['amount']) ? $_POST['amount'] : 0;
        
            $inputAmount = floatval($inputAmount);
    
            // Update the current amount received
            $currentAmount += $inputAmount;

            $_SESSION['currentAmount'] = $currentAmount;
    
            // Check if payment is successful
            if ($currentAmount == $totalBill) {
                
                echo "Payment was successful!";
                // Reset current amount
                unset($_SESSION['currentAmount']);
                unset($_SESSION['change']);

            }
             elseif ($currentAmount < $totalBill) {
                
                $amountNeeded = $totalBill - $currentAmount;
                echo "You have paid $currentAmount. You need to pay " . $amountNeeded . " more.";
            } 
            
            else {
                
                // Calculate change
                $change = $currentAmount - $totalBill;
                echo "Payment successful. Change dispensed: $change";
                // Reset current amount
                unset($_SESSION['currentAmount']);
                unset($_SESSION['change']);
            }
        }
        ?>
        
        <form method="post" action="<?= $_SERVER['PHP_SELF'] ?>">
            <label for="amount">Enter Amount:</label>
            <input type="number" id="amount" name="amount">
            <input type="submit" value="Submit">
        </form>
    
        <br><br><a href="paid.php">Done</a>
    </div>
    
</body>
</html>