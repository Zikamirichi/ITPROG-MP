<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GCash</title>
</head>
<body>

    <h2>INSERT GCASH QR CODE</h2><br><br>

    <?php
        session_start();
        $totalBill = $_SESSION['totalBill'];
        
        echo "<h2>Total Bill: Php $totalBill</h2>";
    ?>
    
    <a href="paid.php">Done</a>
</body>
</html>
    