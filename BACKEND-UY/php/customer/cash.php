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
        border-radius: 5px;
        text-align: center;
        margin: 20px auto;
        width: 400px;
        height: 400px;
        font-family: 'Luckiest Guy', cursive;
        position: relative;
        aspect-ratio: 1/1;
    }

    .cash-prompt h2 {
        margin: 0;
        color: #ffffff;
        background-color: #D4471F;
        padding: 50px 0; 
        border-top-left-radius: 5px;
        border-top-right-radius: 5px;
        font-size: 36px;
        font-weight: bold; 
        width: 100%;
        box-sizing: border-box;
    }

    .cash-prompt .close {
        position: absolute;
        top: 10px;
        right: 10px;
        background-color: #D4471F;
        color: #ffffff;
        border: none;
        padding: 10px 20px;
        font-family: 'Luckiest Guy', cursive;
        border-radius: 50%;
        cursor: pointer;
        font-size: 30px;
        z-index: 1; 
    }

    .cash-prompt .close:hover {
        background-color: #B42B00;
    }

    .cash-prompt .total-bill {
        font-size: 24px; 
        margin-bottom: 20px;
        font-family: 'Luckiest Guy', cursive;
    }

    .cash-prompt .amount-received {
        font-size: 24px;
        margin-bottom: 20px;
        font-family: 'Luckiest Guy', cursive;
    }

    .cash-prompt .submit-button {
        background-color: #CED3D7;
        color: #000000;
        border: none;
        padding: 15px 45px;
        border-radius: 50px;
        font-family: 'Luckiest Guy', cursive;
        font-size: 30px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        width: 200px;
        text-transform: uppercase;
    }

    .cash-prompt .submit-button:hover {
        background-color: #45a049;
    }

    .cash-prompt form {
        margin-top: 20px;
    }

    .cash-prompt form label {
        font-size: 24px;
        margin-bottom: 10px;
        font-family: 'Luckiest Guy', cursive;
    }

    .cash-prompt form input[type="number"] {
        font-size: 24px;
        padding: 10px;
        border-radius: 5px;
        border: 1px solid #ccc;
        width: 300px;
        font-family: 'Luckiest Guy', cursive;
    }

    .cash-prompt form input[type="submit"] {
        background-color: #CED3D7;
        color: #000000;
        border: none;
        padding: 15px 45px;
        border-radius: 50px;
        font-family: 'Luckiest Guy', cursive;
        font-size: 30px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        width: 200px;
        text-transform: uppercase;
    }

    .cash-prompt form input[type="submit"]:hover {
        background-color: #45a049;
    }
</style>
</head>
<body>
    <div class="cash-prompt">
        <h2>Cash Money</h2>
        <a class="close" href="payOptions.php">&times;</a>
        <?php
            session_start();
            $totalBill = $_SESSION['totalBill'];

            $currentAmount = isset($_SESSION['currentAmount']) ? $_SESSION['currentAmount'] : 0; // Current amount received
            $change = isset($_SESSION['change']) ? $_SESSION['change'] : 0; // Change to be dispensed
            
            echo "<p class='total-bill'>Total Bill: Php $totalBill</p>";
            
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
            <label for="amount">Enter Amount:</label><br>
            <input type="number" id="amount" name="amount"><br>
            <input type="submit" class="submit-button" value="Submit">
        </form>
    </div>
    
    <br><br><a href="paid.php">Done</a>
</body>
</html>
