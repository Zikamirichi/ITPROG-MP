<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Credit Card</title>
</head>
<body>
    <h2>INSERT CREDIT CARD TAP PROMPT</h2><br><br>

    <?php
        session_start();
        $totalBill = $_SESSION['totalBill'];
        
        echo "<h2>Total Bill: Php $totalBill</h2>";
    ?>
    
    <a href="paid.php">Done</a>
</body>
</html>