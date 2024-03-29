<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cash</title>
</head>
<body>
    <?php
        session_start();
        $totalBill = $_SESSION['totalBill'];

        $currentAmount = isset($_SESSION['currentAmount']) ? $_SESSION['currentAmount'] : 0; // Current amount received
        $change = isset($_SESSION['change']) ? $_SESSION['change'] : 0; // Change to be dispensed
        
        echo "<h2>Total Bill: Php $totalBill</h2>";
        
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
</body>
</html>